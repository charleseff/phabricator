<?php
final class DropboxDifferentialSecurityReviewFieldSpecification extends DifferentialFieldSpecification {
  private $dropboxSecurityReview;

  public function getStorageKey() {
    return 'dropbox:security-review';
  }

  public function setValueFromStorage($value) {
    $this->dropboxSecurityReview = (bool)$value;
    return $this;
  }

  public function getValueForStorage() {
    return $this->dropboxSecurityReview ? '1' : '0';
  }

  public function shouldAppearOnEdit() {
    return false;
  }

  public function shouldAppearOnConduitView() {
    return true;
  }

  public function getValueForConduit() {
    return $this->dropboxSecurityReview;
  }

  public function getKeyForConduit() {
    return $this->getStorageKey();
  }

  public function shouldAppearOnRevisionView() {
    // attribute isnt populated yet, so always return true here
    return true;
  }

  public function renderLabelForRevisionView() {
    return null;
  }

  public function renderValueForRevisionView() {
    if (!$this->dropboxSecurityReview) {
      return null;
    }
    return phutil_tag('strong', array(), 'This revision requires a security review');
  }

  public function renderWarningBoxForRevisionAccept() {
    if (!$this->dropboxSecurityReview) {
      return null;
    }
    return id(new AphrontErrorView())
      ->setSeverity(AphrontErrorView::SEVERITY_ERROR)
      ->appendChild(phutil_tag('p', array(), 'This revision must be reviewed by a member of the Security team'))
      ->setTitle('Security Review Required');
  }

  public function renderValueForMail($phase) {
    if (!$this->dropboxSecurityReview) {
      return null;
    }

    $output = array();
    $output[] = "***************************************************";
    $output[] = "SECURITY REVIEW REQUIRED";
    $output[] = "***************************************************";
    return implode("\n", $output);
  }
}
