<?php

namespace Botble\ACL\Forms;

use Botble\ACL\Http\Requests\UpdatePasswordRequest;
use Botble\ACL\Models\User;
use Botble\Base\Facades\Html;
use Botble\Base\Forms\FormAbstract;

class PasswordForm extends FormAbstract
{
    public function buildForm(): void
    {
        $this
            ->setupModel(new User())
            ->setValidatorClass(UpdatePasswordRequest::class)
            ->setFormOption('template', 'core/base::forms.form-no-wrap')
            ->setFormOption('id', 'password-form')
            ->setMethod('PUT')
            ->add('old_password', 'password', [
                'label' => trans('core/acl::users.current_password'),
                'required' => true,
                'attr' => [
                    'data-counter' => 60,
                ],
            ])
            ->add('rowOpen1', 'html', [
                'html' => '<div class="row">',
            ])
            ->add('password', 'password', [
                'label' => trans('core/acl::users.new_password'),
                'required' => true,
                'attr' => [
                    'data-counter' => 60,
                ],
                'wrapper' => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
                'help_block' => [
                    'text' => Html::tag('span', 'Password Strength', ['class' => 'hidden'])->toHtml(),
                    'tag' => 'div',
                    'attr' => [
                        'class' => 'pwstrength_viewport_progress',
                    ],
                ],
            ])
            ->add('password_confirmation', 'password', [
                'label' => trans('core/acl::users.confirm_new_password'),
                'required' => true,
                'attr' => [
                    'data-counter' => 60,
                ],
                'wrapper' => [
                    'class' => $this->formHelper->getConfig('defaults.wrapper_class') . ' col-md-6',
                ],
            ])
            ->add('rowClose', 'html', [
                'html' => '</div>',
            ])
            ->setActionButtons(view('core/acl::users.profile.actions')->render());
    }
}
