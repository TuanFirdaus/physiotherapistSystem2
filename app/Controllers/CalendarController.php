<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleModel;
use DateTime;

class CalendarController extends BaseController
{
    public function getCalendar()
    {
        // Get the month and year from query params
        $month = $this->request->getVar('month') ?? date('m');
        $year = $this->request->getVar('year') ?? date('Y');

        // Generate the calendar for the requested month and year
        $calendarHtml = $this->generateCalendar($month, $year);

        return $this->response->setJSON([
            'calendarHtml' => $calendarHtml,
            'monthYear' => (new DateTime("{$year}-{$month}-01"))->format('F Y')
        ]);
    }

    public function generateCalendar($month, $year)
    {
        $scheduleModel = new ScheduleModel();

        // Get schedules (events) for the current month and year, including therapist, patient, and user details
        $schedules = $scheduleModel->getScheduleByDate($month, $year);

        // Organize events by day
        $scheduleByDay = [];
        foreach ($schedules as $schedule) {
            $day = (new DateTime($schedule['start_date']))->format('j');  // Extract day number (e.g. 1, 2, 3...)
            if (!isset($scheduleByDay[$day])) {
                $scheduleByDay[$day] = [];
            }
            $scheduleByDay[$day][] = $schedule;  // Add event to the corresponding day
        }

        // Get the first day of the month and number of days in the month
        $firstDay = (new DateTime("{$year}-{$month}-01"))->format('w');
        $daysInMonth = (new DateTime("{$year}-{$month}-01"))->format('t');
        $day = 1;

        $html = '<table class="calendar-table"><tbody>';

        // Generate the calendar grid, filling each day with events if available
        for ($row = 0; $row < 6; $row++) {  // 6 rows are enough to accommodate all the days in the month
            $html .= '<tr>';
            for ($col = 0; $col < 7; $col++) {  // 7 columns for the days of the week
                if (($row == 0 && $col < $firstDay) || $day > $daysInMonth) {
                    $html .= '<td></td>';  // Empty cells
                } else {
                    $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    $html .= "<td class='calendar-cell' data-day='{$day}' data-month='{$month}' data-year='{$year}'>";
                    $html .= "<strong>{$day}</strong>";

                    // Add schedules to the day cell if available
                    if (isset($scheduleByDay[$day])) {
                        $html .= "<ul>";
                        foreach ($scheduleByDay[$day] as $schedule) {
                            $html .= "<li><a href='#' class='schedule-link' data-id='{$schedule['scheduleId']}'>{$schedule['title']}</a></li>";
                        }
                        $html .= "</ul>";
                    }

                    $html .= "</td>";
                    $day++;  // Move to the next day
                }
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }


    // Fetch schedule details
    public function getScheduleDetails($scheduleId)
    {
        $scheduleModel = new ScheduleModel();
        $event = $scheduleModel->getEventWithSlot($scheduleId);
        return $this->response->setJSON($event);
    }

    // Fetch events by day
    public function getAppointmentsByDay()
    {
        $day = $this->request->getVar('day');
        $month = $this->request->getVar('month');
        $year = $this->request->getVar('year');

        // Fetch events for the specific day
        $scheduleModel = new ScheduleModel();
        $schedule = $scheduleModel->getScheduleByDay($day, $month, $year);

        return $this->response->setJSON($schedule);
    }
}
