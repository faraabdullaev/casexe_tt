<?php

namespace backend\models\db;

use common\models\db\Gift;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\db\PrizeReceiver;

/**
 * PrizeReceiverSearch represents the model behind the search form of `common\models\db\PrizeReceiver`.
 */
class PrizeReceiverSearch extends PrizeReceiver
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'prize_type', 'prize_status'], 'integer'],
            [['created_date', 'updated_date', 'game_id', 'user_id', 'prize_value'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = PrizeReceiver::find();
        $query->joinWith(['user', 'game']);

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
            'prize_type' => $this->prize_type,
            'prize_status' => $this->prize_status,
        ]);

        if ($this->prize_type == self::PRIZE_TYPE_IS_GIFT) {
            $query->joinWith('gift');
            $query->andFilterWhere(['like', 'gift.name', $this->prize_value]);
        } else {
            $query->andFilterWhere(['prize_value' => $this->prize_value]);
        }

        $query->andFilterWhere(['like', 'user.username', $this->user_id]);
        $query->andFilterWhere(['like', 'game.name', $this->game_id]);

        return $dataProvider;
    }
}
