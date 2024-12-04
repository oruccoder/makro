<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Tests\Integration\Sync\V1\Service\SyncList;

use Twilio\Exceptions\DeserializeException;
use Twilio\Exceptions\TwilioException;
use Twilio\Http\Response;
use Twilio\Serialize;
use Twilio\Tests\HolodeckTestCase;
use Twilio\Tests\Request;

class SyncListItemTest extends HolodeckTestCase
{
    public function testFetchRequest()
    {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncListItems(1)->fetch();
        } catch (DeserializeException $e) {
        } catch (TwilioException $e) {
        }

        $this->assertRequest(new Request(
            'get',
            'https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/1'
        ));
    }

    public function testFetchResponse()
    {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "created_by": "created_by",
                "data": {},
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "index": 100,
                "list_sid": "ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "revision": "revision",
                "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/100"
            }
            '
        ));

        $actual = $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncListItems(1)->fetch();

        $this->assertNotNull($actual);
    }

    public function testDeleteRequest()
    {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncListItems(1)->delete();
        } catch (DeserializeException $e) {
        } catch (TwilioException $e) {
        }

        $this->assertRequest(new Request(
            'delete',
            'https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/1'
        ));
    }

    public function testDeleteResponse()
    {
        $this->holodeck->mock(new Response(
            204,
            null
        ));

        $actual = $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncListItems(1)->delete();

        $this->assertTrue($actual);
    }

    public function testCreateRequest()
    {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncListItems->create("{}");
        } catch (DeserializeException $e) {
        } catch (TwilioException $e) {
        }

        $values = array('Data' => Serialize::jsonObject("{}"));

        $this->assertRequest(new Request(
            'post',
            'https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items',
            null,
            $values
        ));
    }

    public function testCreateResponse()
    {
        $this->holodeck->mock(new Response(
            201,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "created_by": "created_by",
                "data": {},
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "index": 100,
                "list_sid": "ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "revision": "revision",
                "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/100"
            }
            '
        ));

        $actual = $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncListItems->create("{}");

        $this->assertNotNull($actual);
    }

    public function testReadRequest()
    {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncListItems->read();
        } catch (DeserializeException $e) {
        } catch (TwilioException $e) {
        }

        $this->assertRequest(new Request(
            'get',
            'https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items'
        ));
    }

    public function testReadEmptyResponse()
    {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "items": [],
                "meta": {
                    "first_page_url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0",
                    "key": "items",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0"
                }
            }
            '
        ));

        $actual = $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncListItems->read();

        $this->assertNotNull($actual);
    }

    public function testReadFullResponse()
    {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "items": [
                    {
                        "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "created_by": "created_by",
                        "data": {},
                        "date_created": "2015-07-30T20:00:00Z",
                        "date_updated": "2015-07-30T20:00:00Z",
                        "index": 100,
                        "list_sid": "ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "revision": "revision",
                        "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                        "url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/100"
                    }
                ],
                "meta": {
                    "first_page_url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0",
                    "key": "items",
                    "next_page_url": null,
                    "page": 0,
                    "page_size": 50,
                    "previous_page_url": null,
                    "url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items?PageSize=50&Page=0"
                }
            }
            '
        ));

        $actual = $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncListItems->read();

        $this->assertGreaterThan(0, count($actual));
    }

    public function testUpdateRequest()
    {
        $this->holodeck->mock(new Response(500, ''));

        try {
            $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
                ->syncListItems(1)->update("{}");
        } catch (DeserializeException $e) {
        } catch (TwilioException $e) {
        }

        $values = array('Data' => Serialize::jsonObject("{}"));

        $this->assertRequest(new Request(
            'post',
            'https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/1',
            null,
            $values
        ));
    }

    public function testUpdateResponse()
    {
        $this->holodeck->mock(new Response(
            200,
            '
            {
                "account_sid": "ACaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "created_by": "created_by",
                "data": {},
                "date_created": "2015-07-30T20:00:00Z",
                "date_updated": "2015-07-30T20:00:00Z",
                "index": 100,
                "list_sid": "ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "revision": "revision",
                "service_sid": "ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
                "url": "https://sync.twilio.com/v1/Services/ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Lists/ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa/Items/100"
            }
            '
        ));

        $actual = $this->twilio->sync->v1->services("ISaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncLists("ESaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa")
            ->syncListItems(1)->update("{}");

        $this->assertNotNull($actual);
    }
}