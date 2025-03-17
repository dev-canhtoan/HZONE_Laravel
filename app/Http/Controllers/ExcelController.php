<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelController extends Controller
{
    public function exportOrders()
    {
        $spreadsheet = new Spreadsheet();

        $worksheet = $spreadsheet->getActiveSheet();
        $worksheet->setTitle('Danh sách đơn hàng');

        $headers = [
            'ID Đơn hàng',
            'Mã đơn hàng',
            'Tên người đặt',
            'Số điện thoại',
            'Ngày tạo',
            'Tổng tiền',
            'Trạng thái',
        ];

        $col = 'A';
        foreach ($headers as $header) {
            $worksheet->setCellValue($col . '1', $header);
            $col++;
        }

        $orders = Order::all();

        $row = 2;
        foreach ($orders as $order) {
            $status = '';
            switch ($order->status) {
                case 1:
                    $status = 'Đang chờ duyệt';
                    break;
                case 2:
                    $status = 'Đang giao hàng';
                    break;
                case 3:
                    $status = 'Đã giao hàng';
                    break;
                case 4:
                    $status = 'Đã huỷ';
                    break;
            }

            $worksheet->setCellValue('A' . $row, $order->id);
            $worksheet->setCellValue('B' . $row, $order->order_code);
            $worksheet->setCellValue('C' . $row, $order->user->username);
            $worksheet->setCellValue('D' . $row, $order->user->phone);
            $worksheet->setCellValue('E' . $row, $order->created_at);
            $worksheet->setCellValue('F' . $row, $order->total);
            $worksheet->setCellValue('G' . $row, $status);
            $row++;
        }

        foreach (range('A', 'G') as $col) {
            $worksheet->getColumnDimension($col)->setAutoSize(true);
        }

        $fileName = 'order_data.xlsx';

        $writer = new Xlsx($spreadsheet);
        $writer->save($fileName);

        return response()->download($fileName)->deleteFileAfterSend(true);
    }
}