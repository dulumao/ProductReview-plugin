<?php
namespace Plugin\ProductReview\Tests\Repository;

use Plugin\ProductReview\Entity\ProductReview;
use Eccube\Tests\EccubeTestCase;
use Eccube\Common\Constant;

/**
* Class test repository
* @author Dung Le
*/
class ProductReviewRepositoryGetQueryBuilderBySearchDataTest extends EccubeTestCase
{
    protected $ProductReview;
    protected $Product;

    public function setUp()
    {
        parent::setUp();
        $query = $this->app['orm.em']->getConnection()->getWrappedConnection()->prepare('DELETE FROM plg_product_review');
        $query->execute();

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
     * Test search function
     *
     */
    public function testGetQueryBuilderBySearchDataProductReview()
    {

        $form = array(
            'multi' => $this->ProductReview->getReviewerName(),
            'product_name' => $this->Product->getName(),
            'product_code' => $this->Product->getCodeMin(),
            'sex' => array(
                $this->Sex
                ),
            'recommend_level' => 1,
            'review_start' => new \DateTime(),
            'review_end' => new \DateTime(),
            );

        $form['review_start'] = $form['review_start']->modify('-1 day');
        $form['review_end'] = $form['review_end']->modify('+1 day');

        $qb = $this->app['eccube.plugin.product_review.repository.product_review']->getQueryBuilderBySearchData($form);

        $results = $this->app['paginator']()->paginate($qb);

        $this->assertEquals(1, $results->getTotalItemCount());
    }
}