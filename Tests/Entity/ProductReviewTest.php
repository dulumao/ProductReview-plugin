<?php

namespace Plugin\ProductReview\Tests\Entity;

use Plugin\ProductReview\Entity\ProductReview;
use Eccube\Tests\EccubeTestCase;
use Eccube\Common\Constant;

/**
 * Plugin Entity Test
 *
 * @author Dung Le
 */
class ProductReviewTest extends EccubeTestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testConstructor()
    {
        $ProductReview = new ProductReview();

        $this->expected = 0;

        $this->actual = $ProductReview->getId();
        $this->verify();

        $this->actual = $ProductReview->getReviewerName();
        $this->verify();

        $this->actual = $ProductReview->getReviewerUrl();
        $this->verify();

        $this->actual = $ProductReview->getSex();
        $this->verify();

        $this->actual = $ProductReview->getTitle();
        $this->verify();

        $this->actual = $ProductReview->getComment();
        $this->verify();

        $this->actual = $ProductReview->getStatus();
        $this->verify();

        $this->assertNull($ProductReview->getProduct());
        $this->assertNull($ProductReview->getCustomer());

        $this->actual = $ProductReview->getCreateDate();
        $this->verify();

        $this->actual = $ProductReview->getUpdateDate();
        $this->verify();

        $this->actual = $ProductReview->getDelFlg();
        $this->verify();
    }

    public function testSetId()
    {
        $ProductReview = new ProductReview();

        $this->expected = 1;

        $ProductReview->setId($this->expected);

        $this->actual = $ProductReview->getId();
        $this->verify();
    }

    public function testSetReviewerName()
    {
        $ProductReview = new ProductReview();

        $this->expected = 'Dung Le';

        $ProductReview->setReviewerName($this->expected);

        $this->actual = $ProductReview->getReviewerName();
        $this->verify();
    }

    public function testSetReviewerUrl()
    {
        $ProductReview = new ProductReview();

        $this->expected = 'http://google.com';

        $ProductReview->setReviewerUrl($this->expected);

        $this->actual = $ProductReview->getReviewerUrl();
        $this->verify();
    }

    public function testSetSex()
    {
        $ProductReview = new ProductReview();

        $Sex = new \Eccube\Entity\Master\Sex();
        // $Sex = $this->app['eccube.repository.master.sex']->findBy(array('id' => 1));

        $this->expected = $Sex;

        $ProductReview->setSex($Sex);

        $this->actual = $ProductReview->getSex();
        $this->verify();
    }

    public function testSetTitle()
    {
        $ProductReview = new ProductReview();

        $this->expected = 'This is a test!';

        $ProductReview->setTitle($this->expected);

        $this->actual = $ProductReview->getTitle();
        $this->verify();
    }

    public function testSetComment()
    {
        $ProductReview = new ProductReview();

        $this->expected = 'This is a comment';

        $ProductReview->setComment($this->expected);

        $this->actual = $ProductReview->getComment();
        $this->verify();
    }

    public function testSetStatus()
    {
        $ProductReview = new ProductReview();

        $Disp = $this->app['eccube.repository.master.disp']->find(\Eccube\Entity\Master\Disp::DISPLAY_SHOW);

        $this->expected = $Disp;

        $ProductReview->setStatus($this->expected);

        $this->actual = $ProductReview->getStatus();
        $this->verify();
    }

    public function testSetProduct()
    {
        $ProductReview = new ProductReview();

        $Product = $this->createProduct();

        $this->expected = $Product->getId();

        $ProductReview->setProduct($Product);

        $this->actual = $ProductReview->getProduct()->getId();
        $this->verify();
    }

        public function testSetCustomer()
    {
        $ProductReview = new ProductReview();

        $Customer = $this->createCustomer();

        $this->expected = $Customer->getId();

        $ProductReview->setCustomer($Customer);

        $this->actual = $ProductReview->getCustomer()->getId();
        $this->verify();
    }

        public function testSetDelFlag()
    {
        $ProductReview = new ProductReview();

        $this->expected = Constant::DISABLED;

        $ProductReview->setDelFlg($this->expected);

        $this->actual = $ProductReview->getDelFlg();
        $this->verify();
    }

        public function testSetCreateDate()
    {
        $ProductReview = new ProductReview();

        $this->expected = Date('Y-m-d H:i:s');

        $ProductReview->setCreateDate($this->expected);

        $this->actual = $ProductReview->getCreateDate();
        $this->verify();
    }

        public function testSetUpdateDate()
    {
        $ProductReview = new ProductReview();

        $this->expected = Date('Y-m-d H:i:s');

        $ProductReview->setUpdateDate($this->expected);

        $this->actual = $ProductReview->getUpdateDate();
        $this->verify();
    }
}
