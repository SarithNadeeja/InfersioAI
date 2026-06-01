<?php
declare(strict_types=1);

require_once __DIR__ . "/db.php";

/**
 * @return array{id: int, name: string, company: string, comment_text: string, created_at: string}
 */
function insert_visitor_comment(string $name, string $company, string $comment): array
{
    bootstrap_database();
    $pdo = db();
    $stmt = $pdo->prepare(
        "INSERT INTO visitor_comments (name, company, comment_text)
         VALUES (:name, :company, :comment_text)
         RETURNING id, name, company, comment_text, created_at::text AS created_at"
    );
    $stmt->execute([
        "name" => $name,
        "company" => $company,
        "comment_text" => $comment,
    ]);
    $row = $stmt->fetch();
    if (!$row) {
        throw new RuntimeException("Failed to save comment.");
    }

    return $row;
}

/** @return list<array{id: int, name: string, company: string, comment_text: string, created_at: string}> */
function public_visitor_comments(int $limit = 40): array
{
    bootstrap_database();
    $pdo = db();
    $stmt = $pdo->prepare(
        "SELECT id, name, company, comment_text, created_at
         FROM visitor_comments
         ORDER BY created_at DESC
         LIMIT :limit"
    );
    $stmt->bindValue("limit", $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
