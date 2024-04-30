@component('mail::message')
    @component('mail::header')
            Booking {{ $action }}
    @endcomponent
    <div>Period: {{ $period }}</div>
    <br />
    <table width="100%">
        <tr>
            <td valign="top">
                <h3>Customer Details</h3>
                <div>Name: {{ $customer['customer_name'] }}</div>
                <div>Phone: {{ $customer['phone_number'] }}</div>
                <div>Email: <a href="mailto:'{{ $customer['email'] }}'">{{ $customer['email'] }}</a> </div>
            </td>
            <td valign="top">
                <h3>Room Details</h3>
                <div>Number: {{ $room['number'] }}</div>
                <div>Type: {{ $room['room_type_name'] }}</div>
            </td>
        </tr>
    </table>
@endcomponent


