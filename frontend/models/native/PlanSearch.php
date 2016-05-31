<?php

namespace app\models\native;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\Plan;

/**
 * PlanSearch represents the model behind the search form about `app\models\extend\Plan`.
 */
class PlanSearch extends Plan
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'type', 'province', 'city', 'county', 'country', 'status', 'createtime'], 'integer'],
            [['title', 'content', 'video_ids', 'tag', 'address', 'plan_role', 'plan_skill', 'remark'], 'safe'],
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
        $query = Plan::find();

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
            'type' => $this->type,
            'province' => $this->province,
            'city' => $this->city,
            'county' => $this->county,
            'country' => $this->country,
            'status' => $this->status,
            'createtime' => $this->createtime,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'video_ids', $this->video_ids])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'plan_role', $this->plan_role])
            ->andFilterWhere(['like', 'plan_skill', $this->plan_skill])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
