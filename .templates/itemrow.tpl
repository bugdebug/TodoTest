<tr class='{if $row.finished}finished {/if}{if $row.timedOut}timedout{/if}' id="row{{$row.id}}">
    <td>{{$row.id}}</td>
    <td style='width: 80%'>{{$row.text|escape}}</td>
    <td><nobr>{{$row.deadlineFormatted}}</nobr></td>
    <td>
        <input type="checkbox" id="rowCheckBox{{$row.id}}"
           {if $row.finished}
               checked="checked" disabled="disabled"
           {else}
               onclick="setChecked({{$row.id}})"
           {/if}
        >
    <td>
</tr>