  $('#selectAll').click(function()
    {
        if($(this).is(':checked')){$('.clsSelectSingle').prop('checked',true);
    }else{
        $('.clsSelectSingle').prop('checked',false);
    }
    });
    $('#bulkaction-button').click(function()
    {
         if($('.clsSelectSingle:checked').length==0)
        {
            alert('Please select atleast one service.');
            return false;
        }else if($('#bulkactionSelect').val()==0){alert('Please select action.');
        return false;
            
        }else{
            var t=[];
            $('.clsSelectSingle:checked').each(function(){
                t.push($(this).val());
            });
            var statusConfirm=confirm('Are you want to perform bulk action?');
            if(statusConfirm){
                $('#bulkvalue').val(t.join(','));
               $('#bulkaction-button').parents('form').submit();
                return true;
            }
        }
    });
    function showPreview(t, input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
             $('#'+t).attr('src',e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}