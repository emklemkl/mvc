<?php

namespace App\Form;

use App\Entity\Library;
use App\Form\LibraryType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class LibraryTypeTest extends TypeTestCase
{
    public function testBuildForm()
    {
        $formData = [
            'title' => 'Test Title',
            'isbn' => '1234567890',
            'author' => 'Test Author',
            'cover' => 'img/book_cover.webp',
        ];
        $library = new Library();
        
        $form = $this->factory->create(LibraryType::class, $library);
        $expected = new Library();
        $expected->setTitle($formData["title"]);
        $expected->setIsbn($formData["isbn"]);
        $expected->setAuthor($formData["author"]);
        $expected->setCover($formData["cover"]);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $library);
    }

    public function testBuildFormOnlyIsbn()
    {
        $formData = [
            'isbn' => '1234567890'
        ];
        $library = new Library();
        $form = $this->factory->create(LibraryType::class, $library, ['only_isbn' => true]);

        $expected = new Library();
        $expected->setIsbn($formData["isbn"]);

        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($expected, $library);
    }
}
