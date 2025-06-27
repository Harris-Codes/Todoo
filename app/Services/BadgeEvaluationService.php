<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Submission;
use App\Models\QuizAttempt;
use Illuminate\Support\Facades\Session;

class BadgeEvaluationService
{
    public static function evaluate($studentId, $classroomId)
    {
        $earnedBadges = [];

        $badges = Badge::where('classroom_id', $classroomId)->get();

        foreach ($badges as $badge) {
            $alreadyHas = $badge->awardedToUsers()->where('user_id', $studentId)->exists();
            if ($alreadyHas) continue;

            switch ($badge->type) {
                case 'submission_count':
                    $submissionCount = Submission::where('student_id', $studentId)
                        ->whereHas('assignment', fn($q) => $q->where('classroom_id', $classroomId))
                        ->count();

                    if ($submissionCount >= $badge->condition_value) {
                        $badge->awardedToUsers()->attach($studentId);
                        $earnedBadges[] = $badge;
                    }
                    break;

                    case 'perfect_quiz':
                        $perfectCount = QuizAttempt::where('user_id', $studentId)
                        ->whereHas('quiz', function($q) use ($classroomId) {
                            $q->where('classroom_id', $classroomId);
                        })
                        ->whereHas('quiz', function($q) {
                            $q->whereColumn('quizzes.total_points', 'quiz_attempts.score');
                        })
                        ->count();
                    
                        if ($perfectCount >= $badge->condition_value) {
                            $badge->awardedToUsers()->attach($studentId);
                            $earnedBadges[] = $badge;
                        }
                        break;
                    

                case 'quiz_count':
                    $quizCount = QuizAttempt::where('user_id', $studentId)
                        ->whereHas('quiz', fn($q) => $q->where('classroom_id', $classroomId))
                        ->count();

                    if ($quizCount >= $badge->condition_value) {
                        $badge->awardedToUsers()->attach($studentId);
                        $earnedBadges[] = $badge;
                    }
                    break;
            }
        }

        /** @var \Illuminate\Session\Store $session */
        $session = session();

        if (!empty($earnedBadges)) {
            $session->flash('new_badge', [
                'name' => $earnedBadges[0]->name,
                'image' => $earnedBadges[0]->image,
                'type' => $earnedBadges[0]->type,
                'condition_value' => $earnedBadges[0]->condition_value
            ]);
        }

        

        return $earnedBadges;
    }
}
