<?php
namespace Plugin\ProductReview\Tests\Web;

use Eccube\Tests\Web\Admin\AbstractAdminWebTestCase;
use Plugin\ProductReview\Entity\ProductReview;

/**
* Web test
*/
class ProductReviewControllerTest extends AbstractAdminWebTestCase
{
    protected $ProductReview;
    protected $Product;
    public function setUp()
    {
        parent::setUp();
        $this->ProductReview = $this->newProductReviewer();
    }

    public function createFormData()
    {
        $faker = $this->getFaker();
        $form = array(
            'reviewer_name' => $faker->word,
            'reviewer_url' => $faker->url,
            'sex' => 1,
            'recommend_level' => rand(1,5),
            'title' => $faker->word,
            'comment' => $faker->word,
            'status' => 1,
            '_token' => 'dummy',
        );
        return $form;
    }

    public function newProductReviewer()
    {
        $faker = $this->getFaker();
        $Review = new ProductReview();
        // product create
        $this->Product = $this->createProduct();
        $Disp = $this->app['eccube.repository.master.disp']->find(1);
        $Review
            ->setReviewerUrl($faker->url)
            ->setComment($faker->word)
            ->setDelFlg(0)
            ->setReviewerName($faker->word)
            ->setRecommendLevel(5)
            ->setTitle($faker->word)
            ->setProduct($this->Product)
            ->setStatus($Disp);
        $this->app['orm.em']->persist($Review);
        $this->app['orm.em']->flush();

        return $Review;
    }

    /**
     * Test routing search
     *
     */
    public function testRoutingAdminProductReviewSearch()
    {
        $this->client->request('GET',
            $this->app->url('admin_product_review')
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Test routing edit
     *
     */
    public function testRoutingAdminProductReviewEdit()
    {
        $this->client->request('GET',
            $this->app->url('admin_product_review_edit', array('id' => $this->ProductReview->getId()))
        );
        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Edit test
     */
    public function testAdminProductReviewEdit()
    {
        $formData = $this->doSubmitForm();

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('admin_product_review')));

        $this->expected = $formData['reviewer_name'];

        $this->actual = $this->ProductReview->getReviewerName();
        $this->verify();
    }

    /**
     * Delete test
     */
    public function testAdminProductReviewDelete()
    {
        $this->client->request('GET',
            $this->app->url('admin_product_review_delete', array('id' => $this->ProductReview->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isRedirect($this->app->url('admin_product_review')));

        $this->expected = 1;
        $this->actual = $this->ProductReview->getDelFlg();
        $this->verify();
    }

    /**
     * Detail test
     */
    public function testProductReviewDetail()
    {
        $this->client->request('GET',
            $this->app->url('products_detail_review', array('id' => $this->Product->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Complete test
     */
    public function testProductReviewComplete()
    {
        $this->client->request('GET',
            $this->app->url('products_detail_review_complete', array('id' => $this->ProductReview->getId()))
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    /**
     * Error test
     */
    public function testProductReviewError()
    {
        $this->client->request('GET',
            $this->app->url('products_detail_review_error')
        );

        $this->assertTrue($this->client->getResponse()->isSuccessful());
    }

    protected function doSubmitForm()
    {
        $formData = $this->createFormData();

        $this->crawler = $this->client->request(
            'POST',
            $this->app->url('admin_product_review_edit', array('id' => $this->ProductReview->getId())),
            array(
                'admin_product_review' => $formData
            )
        );

        return $formData;
    }
}
