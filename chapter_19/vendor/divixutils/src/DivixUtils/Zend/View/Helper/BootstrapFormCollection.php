<?php

namespace DivixUtils\Zend\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection as CollectionElement;
use Zend\Form\FieldsetInterface;
use Zend\Form\LabelAwareInterface;

class BootstrapFormCollection extends \Zend\Form\View\Helper\FormCollection
{   
    protected $defaultElementHelper = 'bootstrapFormRow';
    
    /**
     * Invoke helper as function
     *
     * Proxies to {@link render()}.
     *
     * @param  ElementInterface|null $element
     * @param  bool                  $wrap
     * @return string|FormCollection
     */
    public function __invoke(ElementInterface $element = null, $labelPosition = null, $wrap = false)
    {
        if (!$element) {
            return $this;
        }

        $this->setShouldWrap($wrap);

        return $this->render($element, $labelPosition);
    }
    /**
     * Render a collection by iterating through all fieldsets and elements
     *
     * @param  ElementInterface $element
     * @return string
     */
    public function render(ElementInterface $element, $labelPosition = null)
    {
        $renderer = $this->getView();
        if (!method_exists($renderer, 'plugin')) {
            // check if we have renderer plugin
            return '';
        }

        $markup           = '';
        $templateMarkup   = '';
        //$this->setDefaultElementHelper('bootstrapFormRow');
        $elementHelper    = $this->getElementHelper();
        $fieldsetHelper   = $this->getFieldsetHelper();

        if ($element instanceof CollectionElement && $element->shouldCreateTemplate()) {
            $templateMarkup = $this->renderTemplate($element);
        }
        $this->shouldWrap = false;
        
        foreach ($element->getIterator() as $elementOrFieldset) {
            if ($elementOrFieldset instanceof FieldsetInterface) {
                $markup .= $fieldsetHelper($elementOrFieldset, $this->shouldWrap());
            } elseif ($elementOrFieldset instanceof ElementInterface) {
                $markup .= $elementHelper($elementOrFieldset, $labelPosition);
            }
        }

        // every collection of elements is placed according to the specified style
        if ($this->shouldWrap) {
            $attributes = $element->getAttributes();
            unset($attributes['name']);
            $attributesString = count($attributes) ? ' ' . $this->createAttributesString($attributes) : '';

            $label = $element->getLabel();
            $legend = '';

            if (!empty($label)) {
                if (null !== ($translator = $this->getTranslator())) {
                    $label = $translator->translate(
                        $label,
                        $this->getTranslatorTextDomain()
                    );
                }

                if (! $element instanceof LabelAwareInterface || ! $element->getLabelOption('disable_html_escape')) {
                    $escapeHtmlHelper = $this->getEscapeHtmlHelper();
                    $label = $escapeHtmlHelper($label);
                }

                $legend = sprintf(
                    $this->labelWrapper,
                    $label
                );
            }

            $markup = sprintf(
                $this->wrapper,
                $markup,
                $legend,
                $templateMarkup,
                $attributesString
            );
        } else {
            $markup .= $templateMarkup;
        }

        return $markup;
    }
}
