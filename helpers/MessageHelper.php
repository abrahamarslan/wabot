<?php


class MessageHelper
{

    public static function doesSequenceHaveConditional($sequenceID, $campaignID) {
        try {
            $hasConditional = \App\Models\Conditional::where('campaign_id',$campaignID)->where('sequence_id', $sequenceID)->first();
            return ($hasConditional == null ? false : $hasConditional);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function doesContactHaveRunningCampaign($contactID) {
        try {
            $hasRunning = \App\Models\Running::where('contact_id',$contactID)->first();
            return ($hasRunning == null ? false : $hasRunning);
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNextSequenceID($sequenceID) {
        try {
            $sequence = \App\Models\Sequence::where('id',$sequenceID)->first();
            $nextSequenceOrder = $sequence->order + 1;
            $hasNextSequence = \App\Models\Sequence::where('order',$nextSequenceOrder)->first();
            if($hasNextSequence) {
                return $hasNextSequence->id;
            } else {
                return -1;
            }
        } catch (Exception $e) {
            return -1;
        }
    }

    public static function insertRunning($campaignID, $sequenceID, $contactID) {
        try {
            $running = new \App\Models\Running;
            $running->campaign_id = $campaignID;
            $running->contact_id = $contactID;
            $running->sequence_id = $sequenceID;
            $running->last_sequence_id = $sequenceID;
            $nextSequenceID = self::getNextSequenceID($sequenceID);
            $running->next_sequence_id = $nextSequenceID;
            $running->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function insertMessage($campaignID, $sequenceID, $contactID,
     $fromNumber, $toNumber, $isSent=0, $direction='send', $type= 'out', $body='' ) {
        try {
            $message = new \App\Models\Message;
            $message->campaign_id = $campaignID;
            $message->contact_id = $contactID;
            $message->sequence_id = $sequenceID;
            $message->last_sequence_id = $sequenceID;
            $nextSequenceID = self::getNextSequenceID($sequenceID);
            $running->next_sequence_id = $nextSequenceID;
            $running->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function deleteRunningCampaign($campaignID, $sequenceID, $contactID) {
        try {
            $running = \App\Models\Running::where('contact_id',$contactID)->where('campaign_id', $campaignID)->first();
            $running->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function queueCampaign($campaignID, $sequenceID, $contactID) {
        try {
            $queue = new \App\Models\Queue;
            $queue->campaign_id = $campaignID;
            $queue->contact_id = $contactID;
            $queue->sequence_id = $sequenceID;
            $queue->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function hasOptions($sequence) {
        try {
            $optArray = array();
            $i = 1;
            foreach ($sequence->options as $option) {
                if(is_null($option["options"]) or empty($option["options"])) {
                    continue;
                }
                array_push($optArray, ['key' => $i, 'value' => $option["options"]]);
                $i++;
            }
            return $optArray;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function composeMessage($sequenceID) {
        try {
            $sequence = \App\Models\Sequence::where('id',$sequenceID)->first();
            $message = '';
            $message .= $sequence->body;
            $options = self::hasOptions($sequence);
            if(!empty($options) and !is_null($options) and $options) {
                $message .= '\n';
                foreach ($options as $key => $value) {
                    $message .= $key . '. ' . $value;
                    $message .= '\n';
                }
            }
            return $message;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     *
     * @param $haystack
     * @param $needle
     * @return bool
     */
    public static function startsWith($haystack, $needle)
    {
        return !strncmp($haystack, $needle, strlen($needle));
    }

    /**
     * @param $haystack
     * @param $needle
     * @return bool
     */

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);

        if ($length == 0) {
            return true;
        }

        return (substr($haystack, -$length) === $needle);
    }
}
