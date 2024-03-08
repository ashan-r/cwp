jQuery(function ($) {
    $(document).ready(function () {

        // Function to get window height
        const windowHeight = () => $(window).height();

        // Function to update the back to top button positions
        const backToTopButton = $("a.scrollup");
        const backToTopButtonOrgPos = 20, bottomOffset = 80;

        function updateButtonPositions() {
            const height = windowHeight();
            var scrollHeight = $(document).height();
            var scrollTop = $(window).scrollTop();

            if (scrollHeight - (scrollTop + height) <= bottomOffset) {
                backToTopButton.css({
                    bottom: bottomOffset + "px"
                });
            } else {
                backToTopButton.css({
                    bottom: backToTopButtonOrgPos + "px"
                });
            }
        }

        updateButtonPositions();

        // Call the functions when scrolling
        $(window).scroll(function () {
            updateButtonPositions();
        });
    })
})

