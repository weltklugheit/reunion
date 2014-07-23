<?php
    $element = $this->element;
    /* @var $element \Zend\Form\Element */

    switch ($element->getAttribute('type')) {
        case 'textarea':
        $content = '<label for="input'.$element->getAttribute('name').'" class="col-sm-2 control-label">';
            $content .= $element->getLabel();
            $content .= '</label>';
            $content .= '<textarea class="form-control" rows="3" id="input'.$element->getAttribute('name').'"></textarea>';
            break;
        default:
            $content = '<label for="input'.$element->getAttribute('name').'" class="col-sm-2 control-label">';
            $content .= $element->getLabel();
            $content .= '</label>';
            $content .= '<input type="'.$element->getAttribute('type').'" class="form-control" id="input'.$element->getAttribute('name').'"/>';
            break;

    }

    echo $content;
