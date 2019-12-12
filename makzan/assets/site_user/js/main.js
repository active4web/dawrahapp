(function($) {
    // Start rating system on product-single.html page
    $('#stars li').on('mouseover', function() {
        let onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
        // Now, highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function(e){
            if (e < onStar) {
                $(this).addClass('hover');
            }
            else {
                $(this).removeClass('hover');
            }
        });
    }).on('mouseout', function(){
        $(this).parent().children('li.star').each(function(e){
            $(this).removeClass('hover');
        });
    });

    // Action to perform on click
    $('#stars li').on('click', function(){
        let onStar = parseInt($(this).data('value'), 10); // The star currently selected
        let stars = $(this).parent().children('li.star');
        for (let i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }
        for (let i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }
    });
})(jQuery);


const ratings = {
    sony: 3.4,

  }


// Total Stars
const starsTotal = 5;

// Run getRatings when DOM loads
document.addEventListener('DOMContentLoaded', getRatings);

// Form Elements
const ratingControl = document.getElementById('rating-control');

// Init product

let product;

// Rating control change
ratingControl.addEventListener('blur', (e) => {
  const rating = e.target.value;

  // Make sure 5 or under
  if (rating > 5) {
    alert('Please rate 1 - 5');
    return;
  }

  ratings[product] = rating;

  getRatings();

});

// Get ratings
function getRatings() {
    for (let rating in ratings) {

      // Get percentage
      const starPercentage = (ratings[rating] / starsTotal) * 100;

      // Round to nearest 10
      const starPercentageRounded = `${Math.round(starPercentage / 10) * 10}%`;

      // Set width of stars-inner to percentage
      document.querySelector(`.stars-inner`).style.width = starPercentageRounded;

    }
  }
