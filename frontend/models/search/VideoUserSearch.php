<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\VideoUser;

/**
 * VideoUserSearch represents the model behind the search form about `app\models\extend\VideoUser`.
 */
class VideoUserSearch extends VideoUser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'video_id', 'role', 'is_star', 'status', 'createtime'], 'integer'],
            [['instruction'], 'safe'],
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
        $query = VideoUser::find();

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
            'video_id' => $this->video_id,
            'role' => $this->role,
            'is_star' => $this->is_star,
            'status' => $this->status,
            'createtime' => $this->createtime,
        ]);

        $query->andFilterWhere(['like', 'instruction', $this->instruction]);

        return $dataProvider;
    }
}
