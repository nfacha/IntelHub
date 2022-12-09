<?php

namespace App\Protocol\NMEA;

class NMEAMessage
{
    private $messageType;
    private $time;
    private $latitude;
    private $longitude;
    private $speed;
    private $course;
    private $date;
    private $variation;

    public function __construct($nmeaMessage)
    {
        // Parse the NMEA message and extract the individual data fields
        $dataFields = explode(',', $nmeaMessage);
        $this->messageType = $dataFields[0];

        if ($this->messageType == 'GGA') {
            // Parse GGA message
            $this->time = $dataFields[1];
            $this->latitude = $dataFields[2];
            $this->longitude = $dataFields[4];
        } else if ($this->messageType == 'RMC') {
            // Parse RMC message
            $this->time = $dataFields[1];
            $this->date = $dataFields[9];
            $this->speed = $dataFields[7];
            $this->course = $dataFields[8];
            $this->variation = $dataFields[10];
        }
    }

    public function getMessageType()
    {
        return $this->messageType;
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function getCourse()
    {
        return $this->course;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getVariation()
    {
        return $this->variation;
    }
}
