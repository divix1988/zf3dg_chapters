<?php
namespace DivixUtils\Zend\View\Helper;

use Zend\Form\FormInterface;
use Zend\Form\FieldsetInterface;

/**
 * View helper for displaying forms in bootstrap 3 format.
 */
class BootstrapForm extends \Zend\View\Helper\AbstractHelper
{
    const MODE_INLINE = 'inline';
    const MODE_HORIZONTAL = 'horizontal';
    const MODE_VERTICAL = 'vertical';
    
    protected $formHelper;
    /**
     * Display a form
     *
     * @param  string $message
     * @param  string $mode
     * @throws Exception\RuntimeException
     * @return string
     */
    public function __invoke(FormInterface $form = null, $mode = self::MODE_VERTICAL)
    {
        //$this->formHelper = $this->getView()->plugin('form');
        $this->formHelper = $this->getView()->form();
        if (!$form) {
            return $this;
        }
        
        return $this->render($form, $mode);
    }
    
    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form, $mode = self::MODE_VERTICAL)
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $formContent = '';
        $existingClasses = $form->getAttribute('class');
        //ensure that we don't have any previous bootstrap form classes
        $existingClasses = str_replace('form-horizontal', '', str_replace('form-inline', '', $existingClasses));

        if ($mode == self::MODE_INLINE) {
            $form->setAttribute('class', $existingClasses.' form-inline');
        } elseif ($mode == self::MODE_HORIZONTAL) {
            $form->setAttribute('class', $existingClasses.' form-horizontal');
        }
        
        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent.= $this->getView()->bootstrapFormCollection($element, $mode);
            } else {
                $formContent.= $this->getView()->bootstrapFormRow($element, $mode);
            }
        }

        return $this->formHelper->openTag($form) . $formContent . $this->formHelper->closeTag();
    }
}
