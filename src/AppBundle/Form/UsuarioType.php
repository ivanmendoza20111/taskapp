<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $tipo_usuarios = array('NORMAL'=>'NORMAL', 'TECNICO'=>'TECNICO');

        $builder->add('nombre',TextType::class,array('label'=>'Nombre:','required'=>true,'attr'=>array('class'=>'form-control')))
                ->add('username', TextType::class,array('label'=>'Nombre de Usuario:','required'=>true,'attr'=>array('class'=>'form-control')))
        ->add('tipo_usuario', ChoiceType::class ,array('label'=>'Tipo de Usuario:','choices'=>$tipo_usuarios,
            'choices_as_values' => true,'multiple'=>false,'expanded'=>true
        ))
        ->add('contrasena',RepeatedType::class,array(
            'type'=>PasswordType::class,
            'first_options'=>array('label'=>'Contraseña:','attr'=>array('class'=>'form-control')),
            'second_options'=>array('label'=>'Repetir Contraseña:','attr'=>array('class'=>'form-control'))
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario',
            'csrf_protection'=>false,
            'cascade_validation'=>true,
            'allow_extra_fields'=>true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_usuario';
    }
}
