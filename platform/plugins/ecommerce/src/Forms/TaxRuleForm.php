<?php

namespace Botble\Ecommerce\Forms;

use Botble\Base\Facades\Html;
use Botble\Base\Forms\FormAbstract;
use Botble\Ecommerce\Facades\EcommerceHelper;
use Botble\Ecommerce\Http\Requests\TaxRuleRequest;
use Botble\Ecommerce\Models\Tax;
use Botble\Ecommerce\Models\TaxRule;

class TaxRuleForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new TaxRule())
            ->setValidatorClass(TaxRuleRequest::class)
            ->setFormOption('id', 'ecommerce-tax-rule-form')
            ->withCustomFields()
            ->when($this->request->ajax(), fn () => $this->contentOnly());

        if (! $this->getModel()->getKey()) {
            if ($taxId = $this->request->input('tax_id')) {
                $this
                    ->add('tax_id', 'hidden', [
                        'value' => $taxId,
                    ]);
            } else {
                $taxes = Tax::query()->pluck('title', 'id')->toArray();
                $this
                    ->add('tax_id', 'customSelect', [
                        'label' => trans('plugins/ecommerce::tax.tax'),
                        'choices' => $taxes,
                    ]);
            }
        }

        if (EcommerceHelper::loadCountriesStatesCitiesFromPluginLocation()) {
            $this
                ->add('location', 'selectLocation', [
                    'locationKeys' => [
                        'country' => 'country',
                        'state' => 'state',
                        'city' => 'city',
                    ],
                ]);
        } else {
            $this
                ->add('country', 'customSelect', [
                    'label' => trans('plugins/ecommerce::tax.state'),
                    'attr' => [
                        'data-type' => 'country',
                    ],
                    'choices' => EcommerceHelper::getAvailableCountries(),
                ])
                ->add('state', 'text', [
                    'label' => trans('plugins/ecommerce::tax.state'),
                    'attr' => [
                        'placeholder' => trans('plugins/ecommerce::tax.state'),
                    ],
                ])
                ->add('city', 'text', [
                    'label' => trans('plugins/ecommerce::tax.city'),
                    'attr' => [
                        'placeholder' => trans('plugins/ecommerce::tax.city'),
                    ],
                ]);
        }

        if (EcommerceHelper::isZipCodeEnabled()) {
            $this
                ->add('zip_code', 'text', [
                    'label' => trans('plugins/ecommerce::tax.zip_code'),
                ]);
        }
        $this
            ->add('submitter', 'html', [
                'html' => Html::tag('button', '<i class="fa fa-save me-2"></i>' . trans('core/base::forms.save'), [
                    'class' => 'btn btn-success btn-block',
                ]),
                'wrapper' => [
                    'class' => 'd-grid gap-2',
                ],
            ]);
    }
}
