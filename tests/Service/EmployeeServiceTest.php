<?php

namespace Tests;

use app\service\EmployeeService;
use app\models\Employee;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;

class EmployeeServiceTest extends TestCase {
    /** @var EmployeeService */
    private $employeeService;

    /** @var Employee|MockObject */
    private $employeeMock;

    protected function setUp(): void {
        parent::setUp();
    }
    
    public function testListEmployee() {
        $data = [
            'range' => 5,
            'total_employee' => 2,
            'employees' => ['employee1', 'employee2'],
            'page' => 1,
        ];
    
        $employeeMock = $this->createMock(Employee::class);
    
        // Configurar a expectativa para o método 'count'
        $employeeMock->expects($this->once())
            ->method('count')
            ->willReturn(2);
    
        // Configurar a expectativa para o método 'all'
        $employeeMock->expects($this->once())
            ->method('all')
            ->with(1) 
            ->willReturn(['employee1', 'employee2']); 
    
        
        $employeeMock->expects($this->once())
            ->method('getRange')
            ->willReturn(5);
    
        $employeeService = new EmployeeService($employeeMock);
        $result = $employeeService->listEmployee(1);
        $this->assertEquals($data, $result);
    }
    
    public function testCreateEmployee() {
        $requestData = [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            // Adicione outros dados necessários
        ];
        
        $this->employeeMock = $this->createMock(Employee::class);
        $this->employeeMock->expects($this->once())
            ->method('create')
            ->with($requestData);
        
        $employeeService = new EmployeeService($this->employeeMock);
        $employeeService->create($requestData);
    }

}
