<?php

use Timber\Image;

/**
 * Class TestTimmy
 */
class TestFunctions extends TimmyUnitTestCase {
	public function test_get_timber_image_src() {
		$attachment = $this->create_image();
		$result     = get_timber_image_src( $attachment, 'large' );

		$image = $this->get_upload_url() . '/test-1400x0-c-default.jpg';

		$this->assertEquals( $result, $image );
	}

	public function test_get_timber_image() {
		$attachment = $this->create_image();
		$result     = get_timber_image( $attachment, 'large' );

		$image = ' src="' . $this->get_upload_url() . '/test-1400x0-c-default.jpg" alt=""';

		$this->assertEquals( $result, $image );
	}

	public function test_get_timber_image_texts() {
		$attachment  = $this->create_image();
		$alt_text    = 'A marvellous doggo';
		$description = 'This will be the title';
		$result      = get_timber_image_texts( $attachment, 'large' );

		$this->assertEquals( $result, [
			'alt' => '',
		] );

		$this->set_alt_text( $attachment->ID, $alt_text );
		$this->set_description( $attachment->ID, $description );

		// Reload attachment to get updated values.
		$attachment = new Image( $attachment->ID );

		$result = get_timber_image_texts( $attachment, 'large' );

		$this->assertEquals( $result, [
			'alt'   => $alt_text,
			'title' => $description,
		] );
	}

	public function test_get_timber_image_attributes_responsive() {
		$alt_text   = 'A good boye.';
		$attachment = $this->create_image( [ 'alt' => $alt_text ] );
		$result     = get_timber_image_attributes_responsive( $attachment, 'large' );

		$attributes = [
			'sizes'  => '100vw',
			'src'    => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7',
			'srcset' => $this->get_upload_url() . '/test-560x0-c-default.jpg 560w, ' . $this->get_upload_url() . '/test-1400x0-c-default.jpg 1400w',
			'alt'    => $alt_text,
		];

		$this->assertEquals( $result, $attributes );
	}

	public function test_get_timber_image_responsive() {
		$alt_text   = 'Burrito Wrap';
		$attachment = $this->create_image( [ 'alt' => $alt_text ] );
		$result     = get_timber_image_responsive( $attachment, 'large' );

		$image = ' sizes="100vw" srcset="' . $this->get_upload_url() . '/test-560x0-c-default.jpg 560w, ' . $this->get_upload_url() . '/test-1400x0-c-default.jpg 1400w" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" alt="Burrito Wrap"';

		$this->assertEquals( $result, $image );
	}

	public function test_get_timber_image_responsive_src() {
		$attachment = $this->create_image();
		$result     = get_timber_image_responsive_src( $attachment, 'large' );

		$image = ' sizes="100vw" srcset="' . $this->get_upload_url() . '/test-560x0-c-default.jpg 560w, ' . $this->get_upload_url() . '/test-1400x0-c-default.jpg 1400w" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"';

		$this->assertEquals( $result, $image );
	}

	public function test_get_timber_image_responsive_src_lazy_args() {
		$attachment = $this->create_image();
		$result     = get_timber_image_responsive_src( $attachment, 'large', [
			'lazy_src'    => true,
			'lazy_srcset' => true,
			'lazy_sizes'  => true,
		] );

		$image = sprintf(
			' data-sizes="100vw" data-srcset="%1$s/test-560x0-c-default.jpg 560w, %1$s/test-1400x0-c-default.jpg 1400w" data-src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"',
			$this->get_upload_url()
		);

		$this->assertEquals( $result, $image );
	}

	public function test_get_post_thumbnail() {
		$attachment = $this->create_image();
		$result     = get_post_thumbnail( $attachment );

		$this->assertEquals( $result, false );
	}

	public function test_timber_image_full_with_gif() {
		$attachment = $this->create_image( [ 'file' => 'logo-small.gif' ] );
		$result     = get_timber_image( $attachment, 'full' );

		$image = ' src="' . $this->get_upload_url() . '/logo-small.gif" alt=""';

		$this->assertEquals( $image, $result );
	}
}
