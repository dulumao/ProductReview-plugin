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

class ProductReviewSerchTypeTest extends \Eccube\Tests\Form\Type\AbstractTypeTestCase
{
    /** @var \Eccube\Application */
    protected $app;

    /** @var \Symfony\Component\Form\FormInterface */
    protected $form;

    public function setUp()
    {
        parent::setUp();

        // CSRF tokenを無効にしてFormを作成
        $this->form = $this->app['form.factory']
            ->createBuilder('admin_product_review_search', null, array(
                'csrf_protection' => false,
            ))
            ->getForm();
    }

    public function testInvalid_MaxLength_Multi()
    {
        $this->formData['multi'] = str_repeat('S', $this->app['config']['ltext_len']) . 'S';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Maxlength_ProductName()
    {
        $this->formData['product_name'] = str_repeat('S', $this->app['config']['stext_len']) . 's';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_Maxlength_ProductCode()
    {
        $this->formData['product_code'] = str_repeat('S', $this->app['config']['stext_len']) . 's';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
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

    public function testInvalid_FormatDate_ReviewStart()
    {
        $this->formData['review_start'] = 'S';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }

    public function testInvalid_FormatDate_ReviewEnd()
    {
        $this->formData['review_end'] = 'S';

        $this->form->submit($this->formData);
        $this->assertFalse($this->form->isValid());
    }
}
