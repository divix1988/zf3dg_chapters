<?php
namespace DivixUtils\Zend\View\Helper;

use Zend\Form\Element\Submit;
use Zend\Form\Element\Checkbox;
use Zend\Form\Element\MultiCheckbox;
use Zend\Form\Element\Radio;
use Zend\Form\Element\MonthSelect;
use Zend\Form\Element\Captcha;
use Zend\Form\Element\Button;
use Zend\Form\ElementInterface;
use Zend\Form\LabelAwareInterface;

class BootstrapFormRow extends \Zend\Form\View\Helper\FormRow
{
    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @param  null|string      $labelPosition
     * @throws \Zend\Form\Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element, $labelPosition = null)
    {
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $label           = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();
        $extraClass = '';
        $extraMultiClassLabel = '';
        $extraMultiClassInput = '';

        if (is_null($labelPosition)) {
            $labelPosition = $this->labelPosition;
        }

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator = $this->getTranslator())) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
        // does this element contains errors?
        if (count($element->getMessages()) > 0 && !empty($inputErrorClass)) {
            $extraClass .= $inputErrorClass;
        }

        if ($this->partial) {
            $vars = [
                'element'           => $element,
                'label'             => $label,
                'labelAttributes'   => $this->labelAttributes,
                'labelPosition'     => $labelPosition,
                'renderErrors'      => $this->renderErrors,
            ];

            return $this->view->render($this->partial, $vars);
        }

        if ($this->renderErrors) {
            $elementErrorsHelper->setMessageOpenFormat('<div %s>');
            $elementErrorsHelper->setMessageSeparatorString('<br />');
            $elementErrorsHelper->setMessageCloseString('</div>');
            $elementErrors = $elementErrorsHelper->render($element, ['class' => 'help-block']);
        }

        if ($label) {
            $element->setAttribute('placeholder', $label);
        }
        
        if ($element instanceof Submit) {
            $element->setAttribute('class', 'btn btn-default');
        } elseif ($element instanceof Checkbox || $element instanceof MultiCheckbox) {
            //$element->setAttribute('class', 'checkbox');
        } else {
            $element->setAttribute('class', 'form-control');
        }
        $elementString = $elementHelper->render($element, $labelPosition);
        // hidden elements do not need a <label> -https://github.com/zendframework/zf2/issues/5607
        $type = $element->getAttribute('type');
        
        if (isset($label) && '' !== $label && $type !== 'hidden') {
            $markup = '<div class="form-group '.$extraClass.'">';
            $labelAttributes = ['class' => 'control-label aa'];

            if ($element instanceof LabelAwareInterface) {
                if ($labelPosition == BootstrapForm::MODE_HORIZONTAL) {
                    $labelAttributes['class'] .= ' col-sm-2';
                    $extraMultiClassLabel = 'col-sm-2';
                    $extraMultiClassInput = 'col-sm-10';
                }
                array_merge($labelAttributes, $element->getLabelAttributes());
            }

            if (! $element instanceof LabelAwareInterface || ! $element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }

            // Multicheckbox elements have to be handled differently as the HTML standard does not allow nested
            // labels. The semantic way is to group them inside a fieldset
            if ($type === 'multi_checkbox'
                || $type === 'radio'
                || $element instanceof MonthSelect
                || $element instanceof Captcha
            ) {
                $classMapping = [
                    'radio' => 'radio',
                    'multi_checkbox' => 'checkbox'
                ];
                //echo $extraMultiClassLabel;
                $markup .= sprintf(
                    '<label class="control-label %s">%s</label><div class="%s %s">%s</div>',
                    $extraMultiClassLabel,
                    $label,
                    $classMapping[$type],
                    $extraMultiClassInput,
                    $elementString
                );
            } else {
                // Ensure element and label will be separated if element has an `id`-attribute.
                // If element has label option `always_wrap` it will be nested in any case.
                if ($element->hasAttribute('id')
                    && ($element instanceof LabelAwareInterface && !$element->getLabelOption('always_wrap'))
                ) {
                    $labelOpen = '';
                    $labelClose = '';
                    $label = $labelHelper->openTag($element) . $label . $labelHelper->closeTag();
                } else {
                    $labelOpen  = $labelHelper->openTag($labelAttributes);
                    $labelClose = $labelHelper->closeTag();
                }

                if ($label !== '' && (!$element->hasAttribute('id'))
                    || ($element instanceof LabelAwareInterface && $element->getLabelOption('always_wrap'))
                ) {
                    $label = '<span>' . $label . '</span>';
                }

                // Button element is a special case, because label is always rendered inside it
                if ($element instanceof Button) {
                    $labelOpen = $labelClose = $label = '';
                }

                if ($element instanceof LabelAwareInterface && $element->getLabelOption('label_position')) {
                    $labelPosition = $element->getLabelOption('label_position');
                }

                switch ($labelPosition) {
                    case self::LABEL_PREPEND:
                        $markup .= $labelOpen . $label . $labelClose . $elementString;
                        break;
                    case BootstrapForm::MODE_HORIZONTAL:
                        $markup .= $labelOpen . $label . $labelClose . '<div class="col-sm-10">'. $elementString .'</div>';
                        break;
                    case self::LABEL_APPEND:
                    default:
                        $markup .= $labelOpen . $label . $labelClose . $elementString;
                        break;
                }
            }

            if ($this->renderErrors) {
                $markup .= $elementErrors;
            }
            $markup .= '</div>';
        } else {
            if ($labelPosition === BootstrapForm::MODE_HORIZONTAL && $element instanceof Submit) {
                $elementString = '<div class="form-group"><div class="col-sm-10 col-sm-offset-2">'.$elementString.'</div></div>';
            }
            if ($this->renderErrors) {
                $markup = $elementString . $elementErrors;
            } else {
                $markup = $elementString;
            }
        }

        return $markup;
    }
    
    public function getInputErrorClass() {
        return 'has-error';
    }
}
