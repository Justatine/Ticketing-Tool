<?php

namespace App\Enums;

enum DepartmentEnum: string
{
    case IT = 'IT';
    case TRE = 'TRE';
    case CPO = 'CPO';
    case ACCT = 'ACCT';
    case TAX = 'TAX';
    case BPM = 'BPM';
    case ADMIN = 'ADMIN';
    case OPR = 'OPR';
    case JFC = 'JFC';
    case OCEO = 'OCEO';
    case HR = 'HR';
    case COMC = 'COMC';
    case GNI = 'GNI';
    case COM1 = 'COM1';
    case COM2 = 'COM2';
    case MKT = 'MKT';
    case RDQ = 'RDQ';
    case BLEN = 'BLEN';
    case COMP = 'COMP';
    case AUDIT = 'AUDIT';
    case INS = 'INS';
    case PAYROLL = 'PAYROLL';
    case TRNG = 'TRNG';
    case QMS = 'QMS';

    public function label(): string
    {
        return match($this) {
            self::IT => 'IT',
            self::TRE => 'Treasury',
            self::CPO => 'Central Purchasing Office',
            self::ACCT => 'Accounting',
            self::TAX => 'Tax Department',
            self::BPM => 'Business Process Management',
            self::ADMIN => 'Administration',
            self::OPR => 'Operations',
            self::JFC => 'JFC Department',
            self::OCEO => 'Office of the CEO',
            self::HR => 'Human Resources',
            self::COMC => 'Commercial Department',
            self::GNI => 'GNI Department',
            self::COM1 => 'Commercial Cluster 1',
            self::COM2 => 'Commercial Cluster 2',
            self::MKT => 'Marketing',
            self::RDQ => 'R&D / Quality',
            self::BLEN => 'Blending Department',
            self::COMP => 'Compliance',
            self::AUDIT => 'Audit Department',
            self::INS => 'Insurance',
            self::PAYROLL => 'Payroll Department',
            self::TRNG => 'Training Department',
            self::QMS => 'Quality Management System',
        };
    }
}
