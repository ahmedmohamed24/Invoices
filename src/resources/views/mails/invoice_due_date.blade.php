<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ __('main.app-name') }}</title>
</head>
<body>
    <h1>Invoices due date after one week </h1>
    <table>
        <thead>
            <th>#</th>
            <th>Invoice number</th>
            <th>Invoice Due Date</th>
            <th>Department</th>
            <th>product</th>
            <th>total amount</th>
            <th>view</th>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
                <tr>
                    <td>{{ $loop->index }}</td>
                    <td>{{ $invoice->invoice_number}}</td>
                    <td>{{ $invoice->due_date}}</td>
                    <td>{{ $invoice->getDepartment->title}}</td>
                    <td>{{ $invoice->getProduct->title}}</td>
                    <td>{{ $invoice->total}}</td>
                    <td><a href="{{ route('invoice.show',$invoice->id) }}">View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <footer>
        all copy rights reserved
    </footer>
</body>
</html>
