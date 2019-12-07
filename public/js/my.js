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
