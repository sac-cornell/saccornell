
function confirmDelete() {
  if (confirm("Delete this Resource?")) {
    return true;
  } else {
    // alert('okay');
    return false;
  }

}

//trying to chaange description if read more is clicked
$(".read-more").on("click", function () {
  $(event.currentTarget).siblings(".description").toggleClass('hideD');
  $(event.currentTarget).children().toggleClass('hidden');
});
