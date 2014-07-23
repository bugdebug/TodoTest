{include file="head.tpl"}
<div class="container">
    <div class="page-header">
        <h1>ToDo</h1>
    </div>
    <div>
        <form action="ajax.php" method="post" id="addItemForm">
            <input type="hidden" name="action" value="add">
            <div class='input-group'>
                <input type="text" name="text" value="" class='form-control' autocomplete="off" />
                <span class="input-group-btn">
                    <input type="submit" value='Добавить!' class="btn btn-success" type="button" />
                </span>
            </div>
        </form>
    </div>
    <div id="output" class=''>

    </div>
    <div class='row'>&nbsp;</div>
    <div class="panel panel-default">
        <table class="table" id="todoTable">
            <thead>
            <tr>
                <th>#</th>
                <th>Содержание</th>
                <th>DeadLine</th>
                <th>Ready</th>
            </tr>
            </thead>
            <tbody>
            {foreach $rows as $row}
            {include file="itemrow.tpl"}
            {/foreach}
            </tbody>
        </table>
    </div>
    <table>
</div>
{literal}
<script type="text/javascript">
    $(document).ready(function() {
        var options = {
            target: '#output1',
            success: showResponse,
            dataType: 'json',
            clearForm: true
        };
        $('#addItemForm').ajaxForm(options);
    });
    function showResponse(responseText, statusText, xhr, $form)  {
        var output = $("#output");
        if (statusText == 'success' && responseText != 0) {
            output.html('<div class="alert alert-success" role="alert" id="successBar">Успешно добавлено</div>');
            setTimeout(function () { $("#successBar").fadeOut(); }, 5000);
            $('#todoTable > tbody:last').append(
                '<tr>' +
                '<td>' + responseText.id + '</td>' +
                '<td style="width: 80%">' + responseText.text + '</td>' +
                '<td><nobr>' + responseText.deadlineFormatted + '</nobr></td>' +
                '<td><input type="checkbox"><td>' +
                '</tr>'
            );
        } else {
            output.html('<div class="alert alert-danger alert-dismissible" role="alert">' +
                '<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span>' +
                '<span class="sr-only">Close</span></button>Произошла ошибка при добавлении!</div>');
        }
        //alert('status: ' + statusText + '\n\nresponseText: \n' + responseText +
        //        '\n\nThe output div should have already been updated with the responseText.');
    }
    function setChecked(rowId) {
        $.ajax({
            url: "/ajax.php",
            global: false,
            type: "post",
            data: ({id: rowId, action: "check"}),
            dataType: "json",
            success: function(msg){
                $("#row" + rowId).attr('class', 'finished');
                $("#rowCheckBox" + rowId).attr('disabled', 'disabled');
            }
        });
    }
</script>
{/literal}
{include file="foot.tpl"}