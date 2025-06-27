<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ScheduleModel;
use DateTime;

class CalendarController extends BaseController
{
    public function index()
    {
        // Current date
        $currentDate = new DateTime();
        $month = $currentDate->format('m');
        $year = $currentDate->format('Y');

        // Generate the calendar for the current month and year
        return view('pages/calendar', [
            'monthYear' => $currentDate->format('F Y'),
            'calendarHtml' => $this->generateCalendar($month, $year),
            'month' => $month,
            'year' => $year
        ]);
    }

    public function generateCalendar($month, $year)
    {
        $scheduleModel = new ScheduleModel();

        // Get schedule (events) for the current month and year, including therapist, patient, and user details
        $events = $scheduleModel->getScheduleByDate($month, $year);

        // Organize events by day
        $eventsByDay = [];
        foreach ($events as $event) {
            $day = (new DateTime($event['start_date']))->format('j');
            $eventsByDay[$day][] = $event;
        }

        $firstDay = (new DateTime("{$year}-{$month}-01"))->format('w');
        $daysInMonth = (new DateTime("{$year}-{$month}-01"))->format('t');
        $day = 1;

        $html = '<table class="calendar-table"><tbody>';

        // Generate the calendar grid, filling each day with events if available
        for ($row = 0; $row < 6; $row++) {
            $html .= '<tr>';
            for ($col = 0; $col < 7; $col++) {
                if (($row == 0 && $col < $firstDay) || $day > $daysInMonth) {
                    $html .= '<td></td>'; // Empty cells
                } else {
                    $dateStr = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    $html .= "<td class='calendar-cell' data-day='{$day}' data-month='{$month}' data-year='{$year}'>";
                    $html .= "<strong>{$day}</strong>";

                    // Add events to the day cell if available
                    if (isset($eventsByDay[$day])) {
                        $html .= "<ul>";
                        foreach ($eventsByDay[$day] as $event) {
                            $html .= "<li><a href='#' class='event-link' data-id='{$event['scheduleId']}'>{$event['title']}</a></li>";
                        }
                        $html .= "</ul>";
                    }

                    $html .= "</td>";
                    $day++;
                }
            }
            $html .= '</tr>';
        }

        $html .= '</tbody></table>';
        return $html;
    }

    // Fetch event details
    public function getEventDetails($eventId)
    {
        $scheduleModel = new ScheduleModel();
        $event = $scheduleModel->getEventWithSlot($eventId);
        return $this->response->setJSON($event);
    }

    // Fetch events by day
    public function getAppointmentsByDay()
    {
        $day = $this->request->getVar('day');
        $month = $this->request->getVar('month');
        $year = $this->request->getVar('year');

        // Fetch events for the specific day, including therapist, patient, and user details
        $scheduleModel = new ScheduleModel();
        $events = $scheduleModel->getScheduleByDay($day, $month, $year);

        // Return events as JSON response
        return $this->response->setJSON($events);
    }
}
