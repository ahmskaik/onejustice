

jQuery(document).ready(function() {

    jQuery(document).on('click','.uncheck-all',function() {
        jQuery('.permissions-row .mycheckbox').each(function() {
            jQuery(this).prop('checked', false).removeAttr('checked').removeClass('undetermined');
        });
        jQuery(this).text('Check all').removeClass('uncheck-all').addClass('check-all');
        return false;
    });

    jQuery(document).on('click','.check-all',function() {
        jQuery('.permissions-row .mycheckbox').each(function() {
            jQuery(this).prop('checked',true);
        });
        jQuery(this).text('Uncheck all').removeClass('check-all').addClass('uncheck-all');
        return false;
    });

    function ccheckbox(tthis)
    {
        var liSize = tthis.parents('ul').find('li').length;
        var checkedSize = tthis.parents('ul').find('.ccheckbox:checked').length;
        tthis.parents('.box-permissions').find('.pcheckbox').prop('checked',true);
        if(checkedSize == liSize)
        {
            tthis.parents('.box-permissions').find('.pcheckbox').removeClass('undetermined');
        }
        else if(checkedSize == 0)
        {
            tthis.parents('.box-permissions').find('.pcheckbox').prop('checked', false).removeAttr('checked');
        }
        else
        {
            tthis.parents('.box-permissions').find('.pcheckbox').addClass('undetermined');
        }
    }

    jQuery(document).on('change','.ccheckbox',function() {
        var tthis = jQuery(this);
        ccheckbox(tthis);
        if(tthis.prop('checked')==true)
        {
            tthis.parents('li').find('.check-more').removeClass('display-none');
        }
        else
        {
            tthis.parents('li').find('.check-more').addClass('display-none');
            tthis.parents('li').find('.check-more>.mycheckbox').prop('checked', false).removeAttr('checked');
        }
    });

    function pcheckbox(tthis)
    {
        tthis.removeClass('undetermined');
        if(tthis.prop('checked')==true)
        {
            tthis.parents('.box-permissions').find('.ccheckbox').prop('checked',true);
            tthis.parents('.box-permissions').find('.check-more').removeClass('display-none');
        }
        else
        {
            tthis.parents('.box-permissions').find('.ccheckbox').prop('checked', false).removeAttr('checked');
            tthis.parents('.box-permissions').find('.check-more').addClass('display-none');
            tthis.parents('.box-permissions').find('.check-more>.mycheckbox').prop('checked', false).removeAttr('checked');
        }
    }

    jQuery(document).on('change','.pcheckbox',function() {
        pcheckbox(jQuery(this));
    });

    $(window).on('load',function(){
        jQuery('input[type=checkbox].ccheckbox').each(function() {
            ccheckbox(jQuery(this));
        });

        jQuery('input[type=checkbox].ccheckbox').each(function() {
            var tthis = jQuery(this);
            if(tthis.prop('checked')==true)
            {
                tthis.parents('li').find('.check-more').removeClass('display-none');
            }
            else
            {
                tthis.parents('li').find('.check-more').addClass('display-none');
                tthis.parents('li').find('.check-more>.mycheckbox').removeAttr('checked');
            }
        });
    });

});
