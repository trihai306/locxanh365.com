<?php

namespace Botble\SimpleSlider\Forms;

use Botble\Base\Forms\FormAbstract;
use Botble\SimpleSlider\Http\Requests\SimpleSliderItemRequest;
use Botble\SimpleSlider\Models\SimpleSliderItem;

class SimpleSliderItemForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setFormOption('template', 'core/base::forms.form-modal')
            ->setupModel(new SimpleSliderItem())
            ->setValidatorClass(SimpleSliderItemRequest::class)
            ->withCustomFields()
            ->add('simple_slider_id', 'hidden', [
                'value' => request()->input('simple_slider_id'),
            ])
            ->add('title', 'text', [
                'label' => trans('core/base::forms.title'),
                'attr' => [
                    'data-counter' => 120,
                ],
            ])
            ->add('link', 'text', [
                'label' => trans('core/base::forms.link'),
                'attr' => [
                    'placeholder' => 'https://',
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label' => trans('core/base::forms.description'),
                'attr' => [
                    'rows' => 4,
                    'placeholder' => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 2000,
                ],
            ])
            ->add('order', 'number', [
                'label' => trans('core/base::forms.order'),
                'attr' => [
                    'placeholder' => trans('core/base::forms.order_by_placeholder'),
                ],
                'default_value' => 0,
            ])
            ->add('image', 'mediaImage', [
                'required' => true,
            ])
            ->add('close', 'button', [
                'label' => trans('core/base::forms.cancel'),
                'attr' => [
                    'class' => 'btn btn-warning',
                    'data-fancybox-close' => true,
                ],
            ])
            ->add('submitter', 'submit', [
                'label' => trans('core/base::forms.save_and_continue'),
                'attr' => [
                    'class' => 'btn btn-info float-end',
                ],
            ]);
    }
}
