<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// start siswa
// siswa > dashboard
Breadcrumbs::for('student.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('student.dashboard'));
});

Breadcrumbs::for('student.book.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Buku', route('student.book.index'));
});

Breadcrumbs::for('student.loan.create', function (BreadcrumbTrail $trail, $bookId) {
    $trail->parent('student.book.index');
    $trail->push('Peminjaman Buku', route('student.loan.create', ['book' => $bookId]));
});

Breadcrumbs::for('student.loan.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Peminjaman', route('student.loan.index'));
});

Breadcrumbs::for('student.loan.show', function (BreadcrumbTrail $trail, $loanId) {
    $trail->parent('student.loan.index');
    $trail->push('Detail', route('student.loan.show', $loanId));
});

Breadcrumbs::for('student.history.index', function (BreadcrumbTrail $trail) {
    $trail->push('Riwayat Peminjaman', route('student.history.index'));
});

Breadcrumbs::for('student.history.show', function (BreadcrumbTrail $trail, $historyId) {
    $trail->parent('student.history.index');
    $trail->push('Detail', route('student.history.show', $historyId));
});

Breadcrumbs::for('student.profile.index', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('student.profile.index'));
});

Breadcrumbs::for('student.profile.edit', function (BreadcrumbTrail $trail, $profileId) {
    $trail->parent('student.profile.index');
    $trail->push('Edit Profile', route('student.profile.edit', $profileId));
});

Breadcrumbs::for('student.password.edit', function (BreadcrumbTrail $trail, $passwordId) {
    $trail->parent('student.profile.index');
    $trail->push('Edit Password', route('student.password.edit', $passwordId));
});

// end siswa

// start admin
// admin > dashboard
Breadcrumbs::for('admin.dashboard', function (BreadcrumbTrail $trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

Breadcrumbs::for('admin.book.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Buku', route('admin.book.index'));
});

Breadcrumbs::for('admin.book.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.book.index');
    $trail->push('Tambah', route('admin.book.create'));
});

Breadcrumbs::for('admin.book.edit', function (BreadcrumbTrail $trail, $bookId) {
    $trail->parent('admin.book.index');
    $trail->push('Ubah', route('admin.book.edit', $bookId));
});

Breadcrumbs::for('admin.book.show', function (BreadcrumbTrail $trail, $bookId) {
    $trail->parent('admin.book.index');
    $trail->push('Detail', route('admin.book.show', $bookId));
});

Breadcrumbs::for('admin.category.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Kategori', route('admin.category.index'));
});

Breadcrumbs::for('admin.category.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.category.index');
    $trail->push('Tambah', route('admin.category.create'));
});

Breadcrumbs::for('admin.category.edit', function (BreadcrumbTrail $trail, $categoryId) {
    $trail->parent('admin.category.index');
    $trail->push('Ubah', route('admin.category.edit', $categoryId));
});

Breadcrumbs::for('admin.shelf.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Rak', route('admin.shelf.index'));
});

Breadcrumbs::for('admin.shelf.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.shelf.index');
    $trail->push('Tambah', route('admin.shelf.create'));
});

Breadcrumbs::for('admin.shelf.edit', function (BreadcrumbTrail $trail, $shelfId) {
    $trail->parent('admin.shelf.index');
    $trail->push('Ubah', route('admin.shelf.edit', $shelfId));
});

Breadcrumbs::for('admin.loan.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Peminjaman', route('admin.loan.index'));
});

Breadcrumbs::for('admin.loan.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.loan.index');
    $trail->push('Tambah', route('admin.loan.create'));
});

Breadcrumbs::for('admin.loan.return.create', function (BreadcrumbTrail $trail, $loanId) {
    $trail->parent('admin.loan.index');
    $trail->push('Pengembalian', route('admin.loan.return.create', $loanId));
});

Breadcrumbs::for('admin.loan.edit', function (BreadcrumbTrail $trail, $loanId) {
    $trail->parent('admin.loan.index');
    $trail->push('Ubah', route('admin.loan.edit', $loanId));
});

Breadcrumbs::for('admin.loan.show', function (BreadcrumbTrail $trail, $loanId) {
    $trail->parent('admin.loan.index');
    $trail->push('Detail', route('admin.loan.show', $loanId));
});

Breadcrumbs::for('admin.student.index', function (BreadcrumbTrail $trail) {
    $trail->push('Data Siswa', route('admin.student.index'));
});

Breadcrumbs::for('admin.student.create', function (BreadcrumbTrail $trail) {
    $trail->parent('admin.student.index');
    $trail->push('Tambah', route('admin.student.create'));
});

Breadcrumbs::for('admin.student.edit', function (BreadcrumbTrail $trail, $studentId) {
    $trail->parent('admin.student.index');
    $trail->push('Ubah', route('admin.student.edit', $studentId));
});

Breadcrumbs::for('admin.student.change-password', function (BreadcrumbTrail $trail, $studentId) {
    $trail->parent('admin.student.index');
    $trail->push('Ubah Password', route('admin.student.change-password', $studentId));
});

Breadcrumbs::for('admin.profile.index', function (BreadcrumbTrail $trail) {
    $trail->push('Profile', route('admin.profile.index'));
});

Breadcrumbs::for('admin.profile.edit', function (BreadcrumbTrail $trail, $profileId) {
    $trail->parent('admin.profile.index');
    $trail->push('Edit Profile', route('admin.profile.edit', $profileId));
});

Breadcrumbs::for('admin.password.edit', function (BreadcrumbTrail $trail, $passwordId) {
    $trail->parent('admin.profile.index');
    $trail->push('Edit Password', route('admin.password.edit', $passwordId));
});