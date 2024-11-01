jQuery(function($){
  $(document).ready(function () {
    function run_headline_ajax(event){
     var mainword = $('#trcc_keyword').val();
     console.log(objectL10n.ajaxurl);
     event.preventDefault();
     $("#trcc_result").html("<center><img src=" + objectL10n.spinner + " alt=\"loading now...\"></center>");
     $.ajax({
      type: 'POST',
      url: objectL10n.ajaxurl,
      data: {
        'action' : 'main_check_run',
        'keywords' : mainword,
        'nonce' : objectL10n.nonce,
        'timeout' : 60000
      },
      success: function( response ){
        if(response == "0"){
          var html = '<p>' + objectL10n.error + '</p>';
          html += '<center><button class="button button-primary button-large" id="trcc_check_button">' + objectL10n.check_btn + '</button></center>';
          $("#trcc_result").html(html);
        }else{
          var last_str = response.substr(-1, 1);
          if(last_str == "0"){
            response = response.slice(0,-1)
          }
          $("#trcc_result").html(response);
          if($(".add_headline")){
            $(".add_headline").off('click');
            $(".add_headline").on('click',function(){
              var p = $(this).parents('.archive_headline');
              var text = p.text();
              text = text.replace(/<("[^"]*"|'[^']*'|[^'">])*>/g,'');
              var $allElem = $('#content');
              var activeEditor = tinyMCE.get('content');
              var content = activeEditor.getContent();
              content = content + "<p>" + text + "</p>";
              if(activeEditor!==null){
                activeEditor.setContent(content);
              } else {
                $('#content').val(content);
              }
              p.remove();
            });
          }
        }
      },
      error: function( response ){
        var html = '<p>' + objectL10n.error + '</p>';
        html += '<center><button class="button button-primary button-large" id="trcc_check_button">' + objectL10n.check_btn + '</button></center>';
        $("#trcc_result").html(html);
      }
    });
     $("#trcc_check_button").on('click',function(event){
      run_headline_ajax(event);
    });
     return false;
   }
   $("#trcc_check_button").on('click',function(event){
    run_headline_ajax(event);
  });
 });
});