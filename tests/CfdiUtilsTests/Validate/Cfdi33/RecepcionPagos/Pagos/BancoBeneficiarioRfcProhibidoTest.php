<?php
namespace CfdiUtilsTests\Validate\Cfdi33\RecepcionPagos\Pagos;

use CfdiUtils\Elements\Pagos10\Pago;
use CfdiUtils\Validate\Cfdi33\RecepcionPagos\Pagos\BancoBeneficiarioRfcProhibido;
use CfdiUtils\Validate\Cfdi33\RecepcionPagos\Pagos\ValidatePagoException;
use PHPUnit\Framework\TestCase;

class BancoBeneficiarioRfcProhibidoTest extends TestCase
{
    /**
     * @param string|null $paymentType
     * @param string|null $rfc
     * @testWith ["02", "COSC8001137NA"]
     *           ["02", ""]
     *           ["02", null]
     *           ["01", null]
     */
    public function testValid($paymentType, $rfc)
    {
        $pago = new Pago([
            'FormaDePagoP' => $paymentType,
            'RfcEmisorCtaBen' => $rfc,
        ]);
        $validator = new BancoBeneficiarioRfcProhibido();

        $this->assertTrue($validator->validatePago($pago));
    }

    /**
     * @param string|null $paymentType
     * @param string|null $rfc
     * @testWith ["01", "COSC8001137NA"]
     *           ["01", ""]
     */
    public function testInvalid($paymentType, $rfc)
    {
        $pago = new Pago([
            'FormaDePagoP' => $paymentType,
            'RfcEmisorCtaBen' => $rfc,
        ]);
        $validator = new BancoBeneficiarioRfcProhibido();

        $this->expectException(ValidatePagoException::class);
        $validator->validatePago($pago);
    }
}