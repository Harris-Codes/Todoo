<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\User;
use App\Models\Submission;
use App\Models\QuizAttempt;

class BadgeEvaluationService
{
    /**
     * Check and return badges that a student qualifies for
     */
    public static function evaluate($studentId, $classroomId)
    {
        $earnedBadges = [];
    
        $badges = Badge::where('classroom_id', $classroomId)->get();
    
        foreach ($badges as $badge) {
            switch ($badge->type) {
                case 'submissions':
                    $submissionCount = Submission::where('student_id', $studentId)
                        ->whereHas('assignment', function ($query) use ($classroomId) {
                            $query->where('classroom_id', $classroomId);
                        })->count();
    
                    if ($submissionCount >= $badge->condition_value) {
                        $earnedBadges[] = $badge;
                    }
                    break;
    
                case 'perfect_quizzes':
                    $perfectScoreCount = QuizAttempt::where('user_id', $studentId)
                        ->whereHas('quiz', function ($query) use ($classroomId) {
                            $query->where('classroom_id', $classroomId);
                        })
                        ->whereColumn('score', 'total_points')
                        ->count();
    
                    if ($perfectScoreCount >= $badge->condition_value) {
                        $earnedBadges[] = $badge;
                    }
                    break;
    
                case 'quiz_attempts':
                    $quizAttemptCount = QuizAttempt::where('user_id', $studentId)
                        ->whereHas('quiz', function ($query) use ($classroomId) {
                            $query->where('classroom_id', $classroomId);
                        })->count();
    
                    if ($quizAttemptCount >= $badge->condition_value) {
                        $earnedBadges[] = $badge;
                    }
                    break;
            }
        }

        foreach ($earnedBadges as $badge) {
            $alreadyHas = $badge->awardedToUsers()->where('user_id', $studentId)->exists();
            if (! $alreadyHas) {
                $badge->awardedToUsers()->attach($studentId);
            }
        }
    
        return $earnedBadges;
    }
    
}
