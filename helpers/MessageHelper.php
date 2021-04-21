<?php


use App\Models\Campaign;
use App\Models\Contact;
use App\Models\Sequence;
use Twilio\Rest\Client;

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

    public static function getContact($number) {
        try {
            $num = 3;
            $contactLength = strlen($number);
            $contactNumber = substr($number, $num, $contactLength);
            if($contactNumber) {
                $contact = \App\Models\Contact::where('contact',$contactNumber)->first();
                return $contact;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getSequence($sequenceID) {
        try {
            $record = \App\Models\Sequence::where('id',$sequenceID)->first();
            return ($record == null ? false : $record);
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

    public static function completeCampaignForContact($campaignID, $contactID) {
        try {
            $hasRunning = \App\Models\Running::where('contact_id',$contactID)->where('campaign_id', $campaignID)->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getNextSequenceID($sequenceID) {
        try {
            $sequence = \App\Models\Sequence::where('id',$sequenceID)->first();
            $nextSequenceOrder = $sequence->order + 1;
            $hasNextSequence = \App\Models\Sequence::where('campaign_id', $sequence->campaign_id)->where('order',$nextSequenceOrder)->first();
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

    public static function updateRunning($runningID, $lastSequenceID) {
        try {
            $running = \App\Models\Running::findOrFail($runningID);
            $running->last_sequence_id = $lastSequenceID;
            $nextSequenceID = self::getNextSequenceID($lastSequenceID);
            $running->next_sequence_id = $nextSequenceID;
            $running->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function insertMessage($campaignID, $sequenceID, $contactID,
     $fromNumber, $toNumber, $isSent=0, $direction='send', $type= 'out', $body='', $response=null) {
        try {
            $message = new \App\Models\Message;
            $message->campaign_id = $campaignID;
            $message->contact_id = $contactID;
            $message->sequence_id = $sequenceID;
            if($response) {
                $message->SmsMessageSid = $response->messagingServiceSid;
                $message->response = $response;
            }
            $message->from_number = $fromNumber;
            $message->to_number = $toNumber;
            $message->isSent = $isSent;
            $message->direction = $direction;
            $message->type = $type;
            $message->body = $body;
            $message->save();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function insertReceivedMessage($array) {
        try {
            $message = new \App\Models\Message($array);
            $message->save();
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
            $i = 0;
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


    public static function startCampaign($campaignID) {
        try {
            $campaign = Campaign::findOrFail($campaignID);
            $sequences = $campaign->sequences()->get();
            foreach ($sequences as $sequence) {
                // Get all contacts
                $contacts = $campaign->contacts()->get();
                if($contacts && !empty($contacts)){
                    foreach ($contacts as $contact) {
                        $result = self::sendSequence($campaign->id, $sequence->id, $contact->id);
                        return $result;
                    }
                }
            }

            //$result = self::sendWhatsAppMessage('This is my first message, brah!', 'whatsapp:+917877045455');
            //dd($result);
        } catch (\Exception $e) {
            dd($e);
            return null;
        }
    }


    public static function sendSequence($campaignID, $sequenceID, $contactID) {
        try {
            $campaign = Campaign::findOrFail($campaignID);
            $sequence = Sequence::findOrFail($sequenceID);
            $contact = Contact::findOrFail($contactID);
            // Check if the current contact already has a campaign running on it
            if($sequence->order == 1 and \MessageHelper::doesContactHaveRunningCampaign($contact->id)) {
                // Queue the campaign for this contact
                if(\MessageHelper::queueCampaign($campaign->id, $sequence->id, $contact->id)) {
                    return true;
                }
            } else if ($sequence->order == 1) {
                if($body = \MessageHelper::composeMessage($sequence->id)) {
                    $sendMessage = self::sendWhatsAppMessage($body, '+'.$contact->country_code.$contact->contact);
                    $update = \MessageHelper::insertRunning($campaign->id, $sequence->id, $contact->id);
                    $message = \MessageHelper::insertMessage(
                        $campaign->id,
                        $sequence->id,
                        $contact->id,
                        config('global.twilio.sandbox_number'),
                        '+'.$contact->country_code.$contact->contact,
                        1,
                        'send',
                        'out',
                        $body,
                        $sendMessage->messagingServiceSid
                    );
                    return true;
                }
            }
            return false;
        } catch (\Exception $e) {
            dd($e);
            return false;
        }
    }

    public static function sendWhatsAppMessage(string $message, string $recipient)
    {
        try {
            $twilio_whatsapp_number = config('global.twilio.sandbox_number');
            $sid = getenv("TWILIO_SID");
            $token = getenv("TWILIO_TOKEN");
            $client = new Client($sid, $token);
            return $client->messages->create($recipient, array('from' => "whatsapp:$twilio_whatsapp_number", 'body' => $message));
        } catch (Exception $e) {
            dd($e);
            return null;
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
