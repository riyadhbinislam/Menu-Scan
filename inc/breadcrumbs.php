<?php
	function generateBreadcrumbs($pageTitle) {
		$breadcrumbsList = '<div class="breadcrumbs-alt">';

		// Home breadcrumb
		$breadcrumbsList .= '<span><a href="home">Home</a></span>';

		// Explode the page title by spaces or other separators to get individual parts
		$titleParts = explode(' | ', $pageTitle);
		$url = '/';

		// Generate breadcrumbs
		foreach ($titleParts as $part) {
			$url .= strtolower($part);
			$breadcrumbsList .= '<span><a href="'.$url.'">'.'/'.$part.'</a></span>';
		}

		$breadcrumbsList .= '</div>';
		return $breadcrumbsList;
	}
?>

<?php
function generateBackgroundImage($pageTitle) {
    switch ($pageTitle) {
        case 'Home':
            return 'images/products-11.jpg';
        case 'About':
            return 'images/about.jpg';
        case 'Blog':
            return 'images/blog-2.jpg';
        case 'Cart':
            return 'images/products-2.jpg';
        case 'Checkorder':
            return 'images/products-3.jpg';
        case 'Checkout':
            return 'images/products-4.jpg';
        case 'Contact':
            return 'images/products-5.jpg';
        case 'Invoice':
            return 'images/products-6.jpg';
        case 'Editprofile':
			return 'images/products-7.jpg';
        case 'Profile':
            return 'images/products-8.jpg';
        case 'Shop':
            return 'images/products-9.jpg';
        case 'signup':
            return 'images/products-10.jpg';
        // Add more cases for other pages as needed
        default:
            return 'images/cover-img-1.jpg'; // Default background image
    }
}
?>

<aside id="colorlib-hero" class="breadcrumbs">
    <div class="flexslider">
        <ul class="slides">
            <li style="background-image: url(<?php echo generateBackgroundImage($pageTitle); ?>);">
                <div class="overlay"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 col-md-offset-3 col-sm-12 col-xs-12 slider-text">
                            <div class="slider-text-inner text-center">
                                <h1 class=""><?php echo generateBreadcrumbs($pageTitle); ?></h1>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</aside>