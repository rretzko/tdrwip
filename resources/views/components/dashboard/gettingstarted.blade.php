(<div class="bg-white border border-red-600 rounded px-2 py-1">
    <header class="text-lg italic font-bold text-center">Getting Started!</header>
    Welcome and Thank you for registering at TheDirectorsRoom.com!
    <p>
        This message will remain on the Dashboard until you click the button
        at the bottom of the page.  You can also find it under the 'Site Orientation PDSs'
        box over there on your right.  It'll remain there after you've clicked the
        checkbox, just in case you need it for additional reference!
    </p>

    <p>
        You'll find more details in the 'Getting Started' pdf, but here's the
        quick checklist:
        <ol class="ml-8 list-decimal">
        <li>
            <b>Check your Profile</b>
            <span class="hint text-xs">(See the "<b>{{ auth()->user()->username }}</b>" at the
                top-right-hand corner of the page?  Click that and then the "Profile" link.)</span>
        </li>

        <li>
            <b>Add your school(s)</b><span class="hint text-xs">("Schools" link at the top of the page)</span>
        </li>

        <li>
            <b>Check your organization memberships</b> <span class="hint text-xs">("Organizations" link a the top of the
            page.  This is especially important if you've come here to register your students for an organization's event!)</span>
        </li>

        <li>
            <b>Add Students</b><span class="hint text-xs">(Absolutely! But note, it'll be easier on your time and fingers
            if you'll encourage your students to self-register on StudentFolder.info.  Once they add their information
            there, you'll immediately see it here!)</span>
        </li>

        <li>
            <b>Add Ensembles</b> <span class="hint text-xs">(Really?  Yup.  Our goal is to be your one-stop-shop for
            managing <i>all</i> of the thousands of data points which make up your program.  Ensembles are a big part
            of that program.)</span>
        </li>

        <li>
            <b>Add to your Library</b> <span class="hint text-xs">(What's an ensemble without music to perform.
                Build your library here and stop worrying about what music you have.
                We'll keep track of it here...and much more...)</span>
        </li>

        <li>
            <b>Register your students for open Events</b> <span class="hint text-xs">(Once approved for organization
            membership and populating your student roster, you can use that information to quickly register your
            students on-line for your organization's events.  And your students can again save you time and trouble
            by registering themselves at StudentFolder.info!)</span>
        </li>
    </ol>
    </p>

    <p>
        Looking for a deeper dive?  Click the 'TheDirectorsRoom.com' link for much more detailed information!
    </p>

    <div class="bg-gray-300 mt-4 px-2 py-1 text-center rounded w-11/12 mx-auto">
        <a href="{{ route('dashboard.gettingstarted') }}" class="text-black text-center w-full">OK, I've got it.  You can close now.</a>
    </div>
</div>
)
