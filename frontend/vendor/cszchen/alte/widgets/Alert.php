<?php

namespace cszchen\alte\widgets;

use yii\bootstrap\Widget;
use yii\bootstrap\Html;

class Alert extends Widget
{
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_DANGER = 'danger';
    const TYPE_INFO = 'info';
    /**@var string $type color style of widget* */
    public $type = self::TYPE_SUCCESS;
    /**@var boolean $closable show or not close button* */
    public $closable = true;
    /**@var string $text your message* */
    public $text = '';
    public $header = '';
    /**@var string $icon icon class such as "ion ion-bag  or fa fa-beer"* */
    public $icon = '';
    public function init()
    {
        parent::init();
        if (!$this->icon) {
            switch ($this->type) {
                case self::TYPE_INFO: {
                    $this->icon = 'fa fa-info';
                    break;
                }
                case self::TYPE_DANGER: {
                    $this->icon = 'fa fa-ban';
                    break;
                }
                case self::TYPE_WARNING: {
                    $this->icon = 'fa fa-warning';
                    break;
                }
                case self::TYPE_SUCCESS: {
                    $this->icon = 'fa fa-check';
                    break;
                }
                default: {
                    $this->icon = 'fa fa-question';
                }
            }
        }
    }
    public function run()
    {
        Html::addCssClass($this->options, 'alert');
        Html::addCssClass($this->options, 'alert-' . $this->type);
        if($this->closable){
            Html::addCssClass($this->options, 'alert-dismissable');
        }
        $content = (!$this->closable ? ''
                : '<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>');
        if ($this->header) {
            $content .= Html::tag('h4', Html::tag('i', '', ['class' => $this->icon]). '&nbsp;&nbsp;' . $this->header);
        } else {
            $content .= Html::tag('i', '', ['class' => $this->icon]) . '&nbsp;&nbsp;';
        }
        $content .= $this->text;
        echo Html::tag('div', $content, $this->options);
    }
}
