<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\Video;

/**
 * VideoSearch represents the model behind the search form about `app\models\extend\Video`.
 */
class VideoSearch extends Video {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'uid', 'type', 'province', 'city', 'county', 'country', 'views', 'comments', 'support', 'oppose', 'status', 'createtime'], 'integer'],
            [['title', 'content', 'logo', 'file', 'tag'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = Video::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (is_numeric($this->title)) {
            $this->id = $this->title;
        }

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
            'views' => $this->views,
            'comments' => $this->comments,
            'support' => $this->support,
            'oppose' => $this->oppose,
            //'status' => $this->status,
            'createtime' => $this->createtime,
            'province' => $this->province,
            'city' => $this->city,
            'county' => $this->county,
            'country' => $this->country,
        ]);

        $query->andFilterWhere(is_array($this->status) ? ['in', 'status', $this->status] : ['status' => $this->status]);

        $query->andFilterWhere(['like', 'content', $this->content])
                ->andFilterWhere(['like', 'logo', $this->logo])
                ->andFilterWhere(['like', 'file', $this->file])
                ->andFilterWhere(['like', 'tag', $this->tag]);

        if (!is_numeric($this->title)) {
            $query->andFilterWhere(['like', 'title', $this->title]);
        }

        return $dataProvider;
    }

}
