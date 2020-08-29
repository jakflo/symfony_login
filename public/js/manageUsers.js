$(function() {
    $('.change_roles').click(function() {
        var id = $(this).attr('data-id');
        showChangesRolesForm(id);
    });
    
    $('.delete_user').click(function() {
        var id = $(this).attr('data-id');
        showDeleteUserForm(id);
    });
    
    $('#delete_user_cancel, #change_role_cancel').click(function() {
        hideForms();
    });
    
    if ($('#change_form_failed_id').length > 0) {
        showChangesRolesForm($('#change_form_failed_id').text());
    }
    if ($('#delete_form_failed_id').length > 0) {
        showDeleteUserForm($('#delete_form_failed_id').text());
    }
    
    function showChangesRolesForm(id) {
        hideForms();
        $('#change_roles_wrap').removeClass('hidden');
        var stuff = getDomAndUserName(id);
        $('#change_roles_headline span.user_name').text(stuff.name);
        $(stuff.dom).addClass('marked_edit');
        $('#change_role_id').val(id);
        uncheckRoles();
        $(stuff.dom).find('td div.user_role span').each(function(k, v) {
            var roleId = $(v).attr('data-id');
            $('#change_role_userRole input').each(function(k, v) {
                if ($(v).val() == roleId) {
                    $(v).attr('checked', '');
                }
            });            
        });
    }
    
    function showDeleteUserForm(id) {
        hideForms();
        $('#delete_user_wrap').removeClass('hidden');
        var stuff = getDomAndUserName(id);
        $('#delete_user_headline span.user_name').text(stuff.name);
        $(stuff.dom).addClass('marked_delete');
        $('#delete_user_id').val(id);        
    }
    
    function hideForms() {
        $('div.form_wrap').each(function(k, v) {
            if (!$(v).hasClass('hidden')) {
                $(v).addClass('hidden');
            }
        });
        $('#user_list tr').removeClass('marked_edit').removeClass('marked_delete');
    }
    
    function getDomAndUserName(id) {
        var dom = $('#user_row_' + id);
        var userName = $(dom).find('td.user_name').text();
        return {
            dom: dom, 
            name: userName
        };
    }
    
    function uncheckRoles() {
        $('#change_role_userRole input').each(function(k, v) {
            if ($(v).val() != 1) {
                $(v).removeAttr('checked');
            }
        });
    }
});


