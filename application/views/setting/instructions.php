<!-- <link
  rel="stylesheet"
  href="https://unpkg.com/@shopify/polaris@4.21.0/styles.min.css"
/> -->
<style>
.Polaris-Card {
    background-color: var(--p-surface,#fff);
    box-shadow: var(--p-card-shadow,0 0 0 1px rgba(63,63,68,.05),0 1px 3px 0 rgba(63,63,68,.15));
    outline: .1rem solid transparent;
}
.Polaris-Card__Header {
    padding: 1.6rem 1.6rem 0;
}

.Polaris-Heading {
    font-size: 1.7rem;
    font-weight: 600;
    line-height: 2.4rem;
    margin: 0;
}
.Polaris-Card__Section {
    padding: 1.6rem;
}
.Polaris-Card__SectionHeader {
    padding-bottom: .8rem;
}

.Polaris-Subheading {
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.6rem;
    text-transform: uppercase;
    margin: 0;

}

.Polaris-List__Item{
  margin-bottom: 1%;
}

.Polaris-List {
    padding-left: 2rem;
    margin-top: 0;
    margin-bottom: 0;
    list-style: disc outside none;
}

@media (min-width: 30.625em){
.Polaris-Card__Header {
    padding: 2rem 2rem 0;
}
.Polaris-Card {
    border-radius: var(--p-border-radius-wide,3px);
}
.Polaris-Heading {
    font-size: 1.1rem;
}
.Polaris-Card__Section {
    padding: 2rem;
}
.Polaris-Subheading {
    font-size: 0.8rem;
}
}

</style>
<div style="--top-bar-background:#00848e; --top-bar-background-lighter:#1d9ba4; --top-bar-color:#f9fafb;">
  <div class="Polaris-Card">
    <div class="Polaris-Card__Header">
      <h2 class="Polaris-Heading">Guide</h2>
    </div>
    <div class="Polaris-Card__Section">
      <div class="Polaris-Card__SectionHeader">
        <h3 aria-label="Reports" class="Polaris-Subheading">Setting >> Review Form Setting</h3>
      </div>
      <ul class="Polaris-List">
        <h3 aria-label="Reports" class="Polaris-Subheading">StoreFront Widget</h3>
        <li class="Polaris-List__Item">By default the widget is disabled,admin can enable by toggle on disabled button and click on save button.</li>
        <h3 aria-label="Reports" class="Polaris-Subheading">Customer Accounts</h3>
        <li class="Polaris-List__Item">There are two option and by default its "Disabled", which means that you are allowing non login user to review on the product</li>
        <h3 aria-label="Reports" class="Polaris-Subheading">Auto publish</h3>
        <li class="Polaris-List__Item">There are two option and by default its "Enabled", which means the reviews posted will be shown on product page & for admin it will list under published reviews.If you disable this setting then the review will be under unpublished state and will not seen on product page</li>
        <h3 aria-label="Reports" class="Polaris-Subheading">Layout</h3>
        <li class="Polaris-List__Item">There are two option in which review can be displyed one is "Grid" and other is "List".By default "Grid" is selected</li>
        <h3 aria-label="Reports" class="Polaris-Subheading">Show review form on load</h3>
        <li class="Polaris-List__Item">This signifies that the review form displayed at on load or not.If it is checked the form will be displyed at on load and if it is unchecked then form will be hidden so user have to click on "Write a Review" button to show the form</li>
        <h3 aria-label="Reports" class="Polaris-Subheading">Show Powered by text</h3>
        <li class="Polaris-List__Item">There are two option and by default its "Enabled",which means the brand name will be displayed on the review form.Admin can disable it by unchecking it</li>
        <h3 aria-label="Reports" class="Polaris-Subheading">Form input setting</h3>
        <li class="Polaris-List__Item">Here admin can set the form label and placeholder values</li>
      </ul>
    </div>
    <div class="Polaris-Card__Section">
      <div class="Polaris-Card__SectionHeader">
        <h3 aria-label="Reports" class="Polaris-Subheading">Setting >> Add Review</h3>
      </div>
      <p>Here admin can add reviews to the product.There is a option to select the product on which admin wants to give reviews</p>
    </div>
    <div class="Polaris-Card__Section">
      <div class="Polaris-Card__SectionHeader">
        <h3 aria-label="Reports" class="Polaris-Subheading">Review</h3>
      </div>
      <p>Here all the reviews will be listed.There is the tab named as 'Published','Unpublished',Flagged which will list the reciews by there types.</p>
      <p></p>
      <p>On click on the review title will take the admin where it can reply the review or change the state or delete the review.</p>
    </div>
    <div class="Polaris-Card__Section">
      <div class="Polaris-Card__SectionHeader">
        <h3 aria-label="Reports" class="Polaris-Subheading">Products</h3>
      </div>
      <p>Here all products will be listed on which the review has been given.</p>
      <p>Also the count will be displayed that tells how many reviews is been given till date to that product</p>
      <p>On click on the product title it will take the admin to product based review page , where a short analysis is been shown</p>
      <p>On click on the product title it will take the admin to product based review page , where a short analysis is been shown</p>
    </div>
    <div class="Polaris-Card__Section">
      <div class="Polaris-Card__SectionHeader">
        <h3 aria-label="Reports" class="Polaris-Subheading">Give FeedBack</h3>
      </div>
      <p>Here admin can give the feedback or raise there concern</p>
    </div>
  </div>
</div>
