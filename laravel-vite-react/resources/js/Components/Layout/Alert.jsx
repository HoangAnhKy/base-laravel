const Alert = ({alert}) => {
  return <>
      <div className={`alert alert-${alert?.type ?? "success"} alert-dismissible fade show`} role="alert">
          {alert?.message ?? "Success"}
          <button type="button" className="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  </>
}

export default Alert;