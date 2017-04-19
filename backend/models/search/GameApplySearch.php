<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\GameApply;

/**
 * GameApplySearch represents the model behind the search form about `app\models\extend\GameApply`.
 */
class GameApplySearch extends GameApply
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'game_id', 'amount', 'join_num', 'len_minute', 'len_second', 'status', 'create_time'], 'integer'],
            [['username', 'summary', 'conditions', 'ability', 'advantage'], 'safe'],
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
        $query = GameApply::find();

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
            'user_id' => $this->user_id,
            'game_id' => $this->game_id,
            'amount' => $this->amount,
            'join_num' => $this->join_num,
            'len_minute' => $this->len_minute,
            'len_second' => $this->len_second,
            'status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'conditions', $this->conditions])
            ->andFilterWhere(['like', 'ability', $this->ability])
            ->andFilterWhere(['like', 'advantage', $this->advantage]);

        return $dataProvider;
    }
}
