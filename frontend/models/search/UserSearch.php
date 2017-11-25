<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\User;

class UserSearch extends User {

    public $gender;
    public $good_at_job;
    public $speciality;
    public $usingtime;
    public $province;
    public $city;
    public $county;
    public $country;

    public function rules() {
        return [
            [['id', 'level', 'status', 'createtime'], 'integer'],
            [['username', 'password', 'nickname', 'mobile', 'email', 'avatar', 'gender', 'good_at_job','speciality', 'usingtime'], 'safe'],
            [['province', 'city', 'county', 'country'], 'safe'],
        ];
    }

    public function scenarios() {
        return Model::scenarios();
    }

    public function search($params) {
        $query = User::find();
        $query->joinWith(['profile']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//       echo '<pre>';
//              var_dump($params);echo '</pre>'; 
        $this->load($params);
        
        if(is_numeric($this->nickname)) {
            $this->id = $this->nickname;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tbl_user.id' => $this->id,
            'status' => $this->status,
            'createtime' => $this->createtime,
            'tbl_user_profile.gender' => $this->gender,
            'tbl_user_profile.usingtime' => $this->usingtime,
            'tbl_user_profile.province' => $this->province,
            'tbl_user_profile.city' => $this->city,
            'tbl_user_profile.county' => $this->county,
            'tbl_user_profile.country' => $this->country,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'password', $this->password])                
                ->andFilterWhere(['like', 'mobile', $this->mobile])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'avatar', $this->avatar]);
        
        if(!is_numeric($this->nickname)) {
            $query->andFilterWhere(['like', 'nickname', $this->nickname]);
        }
        
        if(!empty($this->good_at_job)&& is_array($this->good_at_job)) {
            foreach ($this->good_at_job as $good_job) {
                 $good_job_arr[] = ','.$good_job.',';
            }
            
            $query->andFilterWhere(['or like', 'tbl_user_profile.good_at_job',$good_job_arr]);
            
        }
        if(!empty($this->speciality)&& is_array($this->speciality)) {
            foreach ($this->speciality as $speciality) {
                 $speciality_arr[] = ','.$speciality.',';
            }
            
            $query->andFilterWhere(['or like', 'tbl_user_profile.speciality',$speciality_arr]);
        }

        return $dataProvider;
    }

}
