<?php

namespace TPN\EmailTemplatesBundle\Tests\Model\Factory;

use Mockery as m;
use TPN\ClientApiClientBundle\EmailTemplates\Validator\ErrorTrace;
use TPN\EmailTemplatesBundle\Model\Factory\EmailTemplateFactory;

class EmailTemplateFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testCreate()
    {
        $arrayConverter = m::mock('TPN\ClientApiClientBundle\EmailTemplates\ArrayConverterInterface');
        $serializer = m::mock('JMS\Serializer\SerializerInterface');
        $validator = m::mock('TPN\ClientApiClientBundle\EmailTemplates\ValidatorInterface');
        $validator->shouldReceive('validate')->andReturn(new ErrorTrace());

        $logger = m::mock('Psr\Log\LoggerInterface');

        $emailTemplateFactory = new EmailTemplateFactory($serializer, $arrayConverter, $validator, $logger);

        $createdEmailTemplate = $emailTemplateFactory->create();

        $this->assertInstanceOf('TPN\ClientApiClientBundle\Model\EmailTemplate', $createdEmailTemplate);
    }

    public function testCreateFromJson()
    {
        $emailTemplateMock = m::mock("TPN\ClientApiClientBundle\Model\EmailTemplate");
        $emailTemplateMock->shouldReceive('getBody')->once()->andReturn('{body-to-parse}');
        $emailTemplateMock->shouldReceive('setChildren')->with(['test-works'])->once();
        $emailTemplateMock->shouldReceive('render')->once()->andReturn('');
        $emailTemplateMock->shouldReceive('setBody')->once();

        $serializer = m::mock('JMS\Serializer\SerializerInterface');
        $serializer->shouldReceive('deserialize')->with('{}', 'TPN\ClientApiClientBundle\Model\EmailTemplate', 'json')->once()->andReturn($emailTemplateMock);

        $arrayConverter = m::mock('TPN\ClientApiClientBundle\EmailTemplates\ArrayConverterInterface');
        $arrayConverter->shouldReceive('createFromArray')->with('{body-to-parse}')->once()->andReturn(['test-works']);

        $validator = m::mock('TPN\ClientApiClientBundle\EmailTemplates\ValidatorInterface');
        $validator->shouldReceive('validate')->andReturn(new ErrorTrace());

        $logger = m::mock('Psr\Log\LoggerInterface');

        $emailTemplateFactory = new EmailTemplateFactory($serializer, $arrayConverter, $validator, $logger);

        $createdEmailTemplate = $emailTemplateFactory->createFromJson('{}');

        $this->assertInstanceOf('TPN\ClientApiClientBundle\Model\EmailTemplate', $createdEmailTemplate);
    }

    public function testCreateFromJsonCollection()
    {
        $emailTemplateMock1 = m::mock("TPN\ClientApiClientBundle\Model\EmailTemplate");
        $emailTemplateMock1->shouldReceive('getBody')->once()->andReturn('{body-to-parse}');
        $emailTemplateMock1->shouldReceive('setChildren')->with(['test-works'])->once();
        $emailTemplateMock1->shouldReceive('render');
        $emailTemplateMock1->shouldReceive('setBody');

        $emailTemplateMock2 = m::mock("TPN\ClientApiClientBundle\Model\EmailTemplate");
        $emailTemplateMock2->shouldReceive('getBody')->once()->andReturn('{body-to-parse}');
        $emailTemplateMock2->shouldReceive('setChildren')->with(['test-works'])->once();
        $emailTemplateMock2->shouldReceive('render');
        $emailTemplateMock2->shouldReceive('setBody');

        $emailTemplateMock3 = m::mock("TPN\ClientApiClientBundle\Model\EmailTemplate");
        $emailTemplateMock3->shouldReceive('getBody')->once()->andReturn('{body-to-parse}');
        $emailTemplateMock3->shouldReceive('setChildren')->with(['test-works'])->once();
        $emailTemplateMock3->shouldReceive('render');
        $emailTemplateMock3->shouldReceive('setBody');

        $serializer = m::mock('JMS\Serializer\SerializerInterface');
        $serializer->shouldReceive('deserialize')
            ->with('{}', 'array<TPN\ClientApiClientBundle\Model\EmailTemplate>', 'json')
            ->once()
            ->andReturn([
                $emailTemplateMock1,
                $emailTemplateMock2,
                $emailTemplateMock3,
            ]);

        $arrayConverter = m::mock('TPN\ClientApiClientBundle\EmailTemplates\ArrayConverterInterface');
        $arrayConverter->shouldReceive('createFromArray')->with('{body-to-parse}')->times(3)->andReturn(['test-works']);

        $validator = m::mock('TPN\ClientApiClientBundle\EmailTemplates\ValidatorInterface');
        $validator->shouldReceive('validate')->andReturn(new ErrorTrace());

        $logger = m::mock('Psr\Log\LoggerInterface');

        $emailTemplateFactory = new EmailTemplateFactory($serializer, $arrayConverter, $validator, $logger);

        $createdEmailTemplate = $emailTemplateFactory->createFromJsonCollection('{}');

        $this->assertInstanceOf('TPN\ClientApiClientBundle\Model\EmailTemplate', $createdEmailTemplate[0]);
        $this->assertInstanceOf('TPN\ClientApiClientBundle\Model\EmailTemplate', $createdEmailTemplate[1]);
        $this->assertInstanceOf('TPN\ClientApiClientBundle\Model\EmailTemplate', $createdEmailTemplate[2]);
    }
}
