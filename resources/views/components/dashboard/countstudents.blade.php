@props([
'dashboard'
])
<div class="border border-black">
<div class="bg-gray-200 border border-black text-center font-bold">Counts</div>
<table>
    <style>
        table{border-collapse: collapse}
        td,th{border:1px solid black; padding:0 .25rem;}
    </style>
    <tr>
        <td>Students</td>
        <th>{{$dashboard->countStudents}}</th>
    </tr>
    <tr>
        <td>Alumni</td>
        <th>{{$dashboard->countStudentsAlumni}}</th>
    </tr>
    <tr>
        <td>Current</td>
        <th>{{$dashboard->countStudentsCurrent}}</th>
    </tr>
</table>
</div>
