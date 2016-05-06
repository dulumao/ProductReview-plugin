<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace Plugin\ProductReview\Form\Type;

class ProductReviewTypeTest extends \Eccube\Tests\Form\Type\AbstractTypeTestCase
{
    /** @var \Eccube\Application */
    protected $app;

    /** @var \Symfony\Component\Form\FormInterface */
    protected $form;

    /** @var array デフォルト値（正常系）を設定 */
    protected $formData = array(
        'reviewer_name'     => 'Dung Le',
        'reviewer_url'      => 'http://google.com',
        'sex'               => 1,
        'recommend_level'   => 5,
        'title'             => 'Product review',
        'comment'           => 'GOOD Product',
        'status'            => 1
    );

    public function setUp()
    {
        parent::setUp();

        // CSRF tokenを無効にしてFormを作成
        $this->form = $this->app['form.factory']
            ->createBuilder('admin_product_review', null, array(
                'csrf_protection' => false,
            ))
            ->getForm();
    }

    public function testValidData()
    {
        $this->form->submit($this->formData);
        $this->assertTrue($this->form->isValid());
    }

    public function testInvalid_Blank_Name()
    {
        $this->formData['reviewer_name'] = '';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Maxlength_Name()
    {
        $this->formData['reviewer_name'] = str_repeat('S', $this->app['config']['stext_len']) . 'S';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Format_Url()
    {
        $this->formData['reviewer_url'] = 'google.com';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Maxlength_Url()
    {
        $this->formData['reviewer_url'] = 'http://' . str_repeat('S', $this->app['config']['mltext_len']) . '.com';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testValid_Blank_Recommend()
    {
        $this->formData['recommend_level'] = '';

        $this->form->submit($this->formData);
        $this->assertTrue($this->form->isValid());
    }

    public function testInvalid_NotChoices_Recommend()
    {
        $this->formData['recommend_level'] = 6;

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Blank_Title()
    {
        $this->formData['title'] = '';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Maxlength_Title()
    {
        $this->formData['title'] = str_repeat('S', $this->app['config']['stext_len']) . 'S';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Blank_Comment()
    {
        $this->formData['comment'] = '';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Maxlength_Comment()
    {
        $this->formData['comment'] = str_repeat('S', $this->app['config']['ltext_len']) . 'S';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Blank_Status()
    {
        $this->formData['status'] = '';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }
}
