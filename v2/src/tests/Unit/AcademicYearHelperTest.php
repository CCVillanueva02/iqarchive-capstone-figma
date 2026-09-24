<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Unit test for academic calendar parsing and accreditation cycle terms.
 * Author: Vince Mathew
 */
class AcademicYearHelperTest extends TestCase
{
    /**
     * Test academic year boundary formats correctly.
     */
    public function test_academic_year_string_formatting(): void
    {
        $startYear = 2026;
        $ay = sprintf('A.Y. %d–%d', $startYear, $startYear + 1);

        $this->assertEquals('A.Y. 2026–2027', $ay);
    }

    /**
     * Test semester resolution from month.
     */
    public function test_semester_resolution_from_calendar_month(): void
    {
        // First semester: August - December
        $monthAug = 8;
        $sem1 = ($monthAug >= 8 && $monthAug <= 12) ? '1st Semester' : '2nd Semester';
        $this->assertEquals('1st Semester', $sem1);

        // Second semester: January - May
        $monthJan = 1;
        $sem2 = ($monthJan >= 1 && $monthJan <= 5) ? '2nd Semester' : 'Midyear';
        $this->assertEquals('2nd Semester', $sem2);
    }

    /**
     * Test accreditation survey rating thresholds.
     */
    public function test_accreditation_mean_score_thresholds(): void
    {
        $score = 4.25;
        $isLevelIIEligible = $score >= 3.00 && $score < 4.50;

        $this->assertTrue($isLevelIIEligible);
    }
}
