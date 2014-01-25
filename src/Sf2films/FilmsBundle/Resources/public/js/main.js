//My content

addMycontent = function(obj) {
    $.ajax({
        type: "POST",
        url: "/mycontent/add",
        data: {
            id : $(obj).data('id')
        },
        success: function(response){
            if (response == 1) {
                alert("Успешно добавлен");
//                $(obj).removeClass("btn-success").addClass("btn-danger").text("Удалить из моих");
//                $(obj).click(function(){
//                   delMycontent(obj);
//                });
                $(obj).parent().hide();
                $(obj).parent().next().show();
            }
            else {
                alert("Ошибка добавления");
            }
        }
    });
}

delMycontent = function(obj) {
    $.ajax({
        type: "POST",
        url: "/mycontent/del",
        data: {
            id : $(obj).data('id')
        },
        success: function(response){
            if (response == 1) {
                alert("Успешно удален");
//                $(".post_element[id_content='" + $(obj).data('id') + "']").remove();
                $(obj).parent().hide();
                $(obj).parent().prev().show();
            }
            else {
                alert("Ошибка удаления");
            }
        }
    });
}

setRandomMessage = function(obj)
{
  if ($(obj).is(":checked")) {
      $("#post_message").attr("disabled","disabled");
  }
  else {
      $("#post_message").removeAttr("disabled");
  }
};

// Get the div that holds the collection of tags
var collectionHolder = $('ul.tags');

// setup an "add a tag" link
var $addTagLink = $('<a href="#" class="add_tag_link">Добавить тег</a>');
var $newLinkLi = $('<li></li>').append($addTagLink);

function addTagForm(collectionHolder, $newLinkLi) {
    // Get the data-prototype we explained earlier
    var prototype = collectionHolder.attr('data-prototype');

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on the current collection's length.
    var newForm = prototype.replace(/__name__/g, collectionHolder.children().length);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);
    // add a delete link to the new form
    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormA = $('<a href="#">Удалить тег</a>');
    $tagFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        $tagFormLi.remove();
    });
}

$(document).ready(function() {
    // add a delete link to all of the existing tag form li elements
    collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });
    // add the "add a tag" anchor and li to the tags ul
    collectionHolder.append($newLinkLi);

    $addTagLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new tag form (see next code block)
        addTagForm(collectionHolder, $newLinkLi);
    });

    $(".add-mycontent-js").click(function(){
        addMycontent(this);
    });
    $(".del-mycontent-js").click(function(){
        delMycontent(this);
    });
});
