<?php

namespace App\Models;

class ArticleReview extends BaseModel {
    protected $fillable = [
        'mark',
        'description',
        'track_article_id',
        'user_id',
        'status',
        'translation_key'
    ];

    public static function statuses() {
        return [
            'strong accept' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.STRONG_ACCEPT_RADIO',
            'accept' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.ACCEPT_RADIO',
            'weak accept' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.WEAK_ACCEPT_RADIO',
            'borderline paper' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.BORDERLINE_RADIO',
            'weak reject' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.WEAK_REJECT_RADIO',
            'reject' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.REJECT_RADIO',
            'strong reject' => 'STOWARZYSZENIE.MODULES.REVIEWS.REVIEW.STRONG_REJECT_RADIO'
        ];
    }

    public static function addArticleReview($input, &$success) {
        $articleReview = new self();
        self::fillArticleReview($articleReview, $input, $success);

        $articleReview->trackArticle()->update([
            'status' => 'review',
            'translation_key' => TrackArticle::statuses()['review']
        ]);

        return $articleReview;
    }

    public static function updateArticleReview($input, &$success) {
        $articleReview = self::where('id', $input['id'])->first();

        $articleReview->trackArticle()->update([
            'status' => 'reviewed',
            'translation_key' => TrackArticle::statuses()['reviewed']
        ]);

        $articleReview->mark = $input['mark'];
        $articleReview->description = $input['description'];
        $articleReview->status = $input['status'];
        $articleReview->translation_key = self::statuses()[$input['status']];

        self::fillArticleReview($articleReview, $input,$success);

        return $articleReview;
    }

    private static function fillArticleReview(&$articleReview, $input, &$success) {
        $articleReview->track_article_id = $input['track_article_id'];
        $articleReview->user_id = $input['user_id'];
        $success = $articleReview->save();
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function trackArticle() {
        return $this->belongsTo(TrackArticle::class);
    }
}
