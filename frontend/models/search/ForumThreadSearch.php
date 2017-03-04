<?php

namespace app\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\extend\ForumThread;

/**
 * ForumThreadSearch represents the model behind the search form about `app\models\extend\ForumThread`.
 */
class ForumThreadSearch extends ForumThread
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fid', 'user_id', 'views', 'posts', 'recommand', 'status', 'createtime', 'updatetime'], 'integer'],
            [['title', 'content'], 'safe'],
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
        $query = ForumThread::find();

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
            'fid' => $this->fid,
            'user_id' => $this->user_id,
            'views' => $this->views,
            'posts' => $this->posts,
            'recommand' => $this->recommand,
            'status' => $this->status,
            'createtime' => $this->createtime,
            'updatetime' => $this->updatetime,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }
}
