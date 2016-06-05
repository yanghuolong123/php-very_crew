<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\UserProfile;

/**
 * UserProfileSearch represents the model behind the search form about `app\models\extend\UserProfile`.
 */
class UserProfileSearch extends UserProfile
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'gender', 'province', 'city', 'county', 'country'], 'integer'],
            [['birthday', 'weixin', 'qq', 'height', 'weight', 'good_at_job', 'speciality', 'usingtime', 'remark'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = UserProfile::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'gender' => $this->gender,
            'province' => $this->province,
            'city' => $this->city,
            'county' => $this->county,
            'country' => $this->country,
        ]);

        $query->andFilterWhere(['like', 'birthday', $this->birthday])
            ->andFilterWhere(['like', 'weixin', $this->weixin])
            ->andFilterWhere(['like', 'qq', $this->qq])
            ->andFilterWhere(['like', 'height', $this->height])
            ->andFilterWhere(['like', 'weight', $this->weight])
            ->andFilterWhere(['like', 'good_at_job', $this->good_at_job])
            ->andFilterWhere(['like', 'speciality', $this->speciality])
            ->andFilterWhere(['like', 'usingtime', $this->usingtime])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
