<?php

namespace App\Form;

use App\Entity\Library;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class LibraryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options["only_isbn"] == true) {

            $builder
            ->add('isbn', HiddenType::class, [
                'required' => true,
            ])
            ->add('delete', SubmitType::class, ['label' => 'Delete'])
            ;
        } else if ($options["only_isbn"] == true) {

            $builder
            ->add('title', TextType::class)
            ->add('isbn', TextType::class)
            ->add('author', TextType::class)
            ->add('cover', TextType::class, ['attr' => [
                'placeholder' => 'img/book_cover.webp',
            ],])
            ->add('add', SubmitType::class, ['label' => 'Add Book'])
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Library::class,
            "only_isbn" => false,
        ]);
    }
}
