var loc = window.location.protocol + '//' + window.location.host + window.location.pathname;

/*Подтверждение удаления заказа*/
$('.delete').click(function(){
    var res = confirm('Подтвердите удаление!');
    if (!res) return false;
});

/*Редактирование заказа*/
$('.redact').click(function() {
    alert('Вы можете только изменить комментарий.');
});

/*Подтверждение удаления заказа из БД*/
$('.deletebd').click(function() {
    var res = confirm('Подтвердите удаление!');
    if (!res)
        return false;
    res = confirm('ВЫ УДАЛИТЕ ЗАКАЗ ИЗ БД!');
    if (!res)
        return false;
});

/*Подсвечивание активного меню*/
$('.sidebar-menu a').each(function(){
    var link = $(this).attr('href'); 
    if (link === loc) {
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});

$('.dropdown').click(function() {
    $('.dropdown .dropdown-menu').toggleClass('show');
});

