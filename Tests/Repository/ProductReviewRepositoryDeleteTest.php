<?php
namespace Plugin\ProductReview\Tests\Repository;

use Plugin\ProductReview\Entity\ProductReview;
use Eccube\Tests\EccubeTestCase;
use Eccube\Common\Constant;

/**
* Class test repository
* @author Dung Le
*/
class ProductReviewRepositoryDeleteTest extends EccubeTestCase
{
    protected $ProductReview;
    protected $Product;

    public function setUp()
    {
        parent::setUp();
        $faker = $this->getFaker();
        $this->ProductReview = new ProductReview();
        $this->Product = $this->createProduct();

        $Disp = $this->app['eccube.repository.master.disp']->find(\Eccube\Entity\Master\Disp::DISPLAY_HIDE);
        $this->Sex  = $this->app['eccube.repository.master.sex']->findOneBy(array('id' => 1));

        $this->ProductReview
            ->setSex($this->Sex)
            ->setComment($faker->word)
            ->setDelFlg(Constant::DISABLED)
            ->setReviewerName($faker->word)
            ->setRecommendLevel(1)
            ->setTitle($faker->word)
            ->setProduct($this->Product)
            ->setStatus($Disp);
        $this->app['orm.em']->persist($this->ProductReview);
        $this->app['orm.em']->flush();
    }

    /**
     * Test delete function
     *
     */
    public function testDeleteProductReview()
    {
        $status = $this->app['eccube.plugin.product_review.repository.product_review']->delete($this->ProductReview);
        $this->assertTrue($status);
    }
}