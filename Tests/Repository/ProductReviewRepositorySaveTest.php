<?php
namespace Plugin\ProductReview\Tests\Repository;

use Plugin\ProductReview\Entity\ProductReview;
use Eccube\Tests\EccubeTestCase;
use Eccube\Common\Constant;

/**
* Class test repository
* @author Dung Le
*/
class ProductReviewRepositorySaveTest extends EccubeTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test save function
     *
     */
    public function testSaveProductReview()
    {
        $ProductReview = new ProductReview();
        $faker = $this->getFaker();
        $Product = $this->createProduct();
        $Disp = $this->app['eccube.repository.master.disp']->find(\Eccube\Entity\Master\Disp::DISPLAY_HIDE);
        $ProductReview
            ->setComment($faker->word)
            ->setDelFlg(Constant::DISABLED)
            ->setReviewerName($faker->word)
            ->setRecommendLevel(5)
            ->setTitle($faker->word)
            ->setProduct($Product)
            ->setStatus($Disp);

        $status = $this->app['eccube.plugin.product_review.repository.product_review']->save($ProductReview);

        $this->assertTrue($status);
    }
}